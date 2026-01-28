<?php

namespace App\Http\Controllers;

use App\Models\Backup;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use ZipArchive;
use Google\Client;
use Google\Service\Drive;
use Google\Service\Drive\DriveFile;

class BackupController
{
    /** TABEL YANG TIDAK DIBACKUP/RESTORE (untuk menjaga session tetap aktif) */
    private array $excludeTables = [
        'backup',
        'backup_detail',
        'log_aktivitas',
        'sessions',  // Jangan restore sessions agar user tetap login
        'cache',
        'cache_locks',
    ];

    public function index()
    {
        $backups = Backup::with('user')
            ->orderByDesc('tanggal_backup')
            ->get();

        return view('pages.admin.backup', compact('backups'));
    }

    /**
     * BUAT BACKUP (DB + FILE)
     */
    public function create()
    {
        // Check if zip extension is available
        if (!extension_loaded('zip')) {
            return back()->with('error', 'PHP zip extension tidak tersedia di server');
        }

        try {
            $timestamp = now()->format('Ymd_His');
            $backupName = "backup_{$timestamp}";
            
            // Ensure backup directory exists
            $backupRoot = storage_path('app/backup');
            if (!is_dir($backupRoot)) {
                mkdir($backupRoot, 0755, true);
            }
            
            $basePath = "{$backupRoot}/{$backupName}";
            if (!is_dir($basePath)) {
                mkdir($basePath, 0755, true);
            }

            /** =========================
             * 1️⃣ DUMP DATABASE
             ========================= */
            $sqlFile = "{$basePath}/database.sql";
            $this->dumpDatabase($sqlFile);

            /** =========================
             * 2️⃣ COPY FILE ARSIP
             ========================= */
            $documentsPath = storage_path('app/public/documents');
            if (is_dir($documentsPath)) {
                $this->copyDirectory($documentsPath, "{$basePath}/documents");
            }

            /** =========================
             * 3️⃣ ZIP SEMUA
             ========================= */
            $zipPath = storage_path("app/backup/{$backupName}.zip");
            $zip = new ZipArchive;
            
            if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
                throw new \Exception('Gagal membuat file ZIP');
            }
            
            $this->zipFolder($basePath, $zip);
            $zip->close();

            // Upload ke Google Drive (jika token tersedia)
            $this->uploadToGoogleDrive($zipPath, basename($zipPath));

            /** =========================
             * 4️⃣ SIMPAN KE DB
             ========================= */
            Backup::create([
                'id_user' => auth()->user()->id_user,
                'tanggal_backup' => now(),
                'lokasi_file' => "backup/{$backupName}.zip",
                'status' => 'completed',
                'ukuran_file' => filesize($zipPath),
            ]);

            /** =========================
             * 5️⃣ LOG AKTIVITAS
             ========================= */
            $this->logAktivitas('Backup', 'Membuat backup sistem: ' . $backupName . '.zip');

            /** =========================
             * 6️⃣ CLEAN TEMP
             ========================= */
            $this->deleteDirectory($basePath);

            return back()->with('success', 'Backup berhasil dibuat');
        } catch (\Exception $e) {
            return back()->with('error', 'Backup gagal: ' . $e->getMessage());
        }
    }

    /**
     * DOWNLOAD BACKUP
     */
    public function download($id)
    {
        try {
            $backup = Backup::findOrFail($id);
            $path = storage_path('app/' . $backup->lokasi_file);

            if (!file_exists($path)) {
                return back()->with('error', 'File backup tidak ditemukan');
            }

            return response()->download($path);
        } catch (\Exception $e) {
            return back()->with('error', 'Download gagal: ' . $e->getMessage());
        }
    }

    /**
     * RESTORE BACKUP (DB + FILE)
     */
    public function restore(Request $request)
    {
        $request->validate([
            'backup_zip' => 'required|file|mimes:zip'
        ]);

        try {
            // Use Laravel's Storage facade to ensure directory exists
            $restorePath = 'restore';
            if (!Storage::disk('local')->exists($restorePath)) {
                Storage::disk('local')->makeDirectory($restorePath);
            }
            
            $backupDir = storage_path('app/' . $restorePath);
            
            // Double-check directory exists and is writable
            if (!is_dir($backupDir)) {
                @mkdir($backupDir, 0755, true);
            }
            
            if (!is_writable($backupDir)) {
                throw new \Exception('Direktori restore tidak writable: ' . $backupDir);
            }
            
            // Clean any existing files in restore directory
            $this->cleanDirectory($backupDir);

            /** ==========================
             * 1️⃣ SIMPAN ZIP
             * ========================== */
            $zipFilename = time() . '.zip';
            $zipPath = $backupDir . '/' . $zipFilename;
            
            // Use move() with try-catch for better error handling
            $uploaded = $request->file('backup_zip');
            
            try {
                // Try move first (faster)
                $uploaded->move($backupDir, $zipFilename);
            } catch (\Exception $e) {
                // Fallback: copy file contents manually
                $content = file_get_contents($uploaded->getRealPath());
                if ($content === false || file_put_contents($zipPath, $content) === false) {
                    throw new \Exception('Gagal menyimpan file ZIP: ' . $e->getMessage());
                }
            }
            
            if (!file_exists($zipPath)) {
                throw new \Exception('File ZIP tidak tersimpan di server');
            }

            /** ==========================
             * 2️⃣ EXTRACT ZIP
             * ========================== */
            $zip = new \ZipArchive;
            $openResult = $zip->open($zipPath);
            if ($openResult !== true) {
                throw new \Exception('Gagal membuka file ZIP (Error code: ' . $openResult . ')');
            }
            
            // Extract file by file to avoid permission issues
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $filename = $zip->getNameIndex($i);
                $targetPath = $backupDir . '/' . $filename;
                
                // Create directory if extracting a folder
                if (substr($filename, -1) === '/') {
                    @mkdir($targetPath, 0755, true);
                    continue;
                }
                
                // Ensure parent directory exists
                $parentDir = dirname($targetPath);
                if (!is_dir($parentDir)) {
                    @mkdir($parentDir, 0755, true);
                }
                
                // Extract single file
                $content = $zip->getFromIndex($i);
                if ($content === false) {
                    continue; // Skip if can't read
                }
                
                if (file_put_contents($targetPath, $content) === false) {
                    $zip->close();
                    throw new \Exception('Gagal mengekstrak: ' . $filename);
                }
            }
            $zip->close();

            $sqlFile = $backupDir . '/database.sql';
            if (!file_exists($sqlFile)) {
                throw new \Exception('File database.sql tidak ditemukan dalam backup');
            }

            /** ==========================
             * 3️⃣ RESTORE DATABASE (Cross-platform)
             * ========================== */
            $this->restoreDatabase($sqlFile);

            /** ==========================
             * 4️⃣ RESTORE FILE ARSIP
             * ========================== */
            $sourceDocs = $backupDir . '/documents';
            $targetDocs = storage_path('app/public/documents');

            if (file_exists($sourceDocs)) {
                $this->copyFolder($sourceDocs, $targetDocs);
            }

            /** ==========================
             * 5️⃣ BERSIHKAN FILE SEMENTARA
             * ========================== */
            unlink($zipPath);
            if (is_dir($backupDir . '/documents')) {
                $this->deleteDirectory($backupDir . '/documents');
            }

            /** ==========================
             * 6️⃣ LOG AKTIVITAS
             * ========================== */
            $this->logAktivitas('Restore', 'Melakukan restore sistem dari file upload');

            return redirect()
                ->route('backup.index')
                ->with('success', 'Restore sistem berhasil');
        } catch (\Exception $e) {
            return redirect()
                ->route('backup.index')
                ->with('error', 'Restore gagal: ' . $e->getMessage());
        }
    }

    private function copyFolder($source, $destination)
    {
        if (!file_exists($destination)) {
            mkdir($destination, 0755, true);
        }

        foreach (scandir($source) as $file) {
            if ($file == '.' || $file == '..') continue;

            $src = $source . '/' . $file;
            $dst = $destination . '/' . $file;

            if (is_dir($src)) {
                $this->copyFolder($src, $dst);
            } else {
                copy($src, $dst);
            }
        }
    }

    public function restoreById($id)
    {
        $backup = Backup::findOrFail($id);
        $zipPath = storage_path('app/' . $backup->lokasi_file);

        if (!file_exists($zipPath)) {
            return redirect()->route('backup.index')->with('error', 'File backup tidak ditemukan');
        }

        try {
            // Use Laravel's Storage facade to ensure directory exists
            $restorePath = 'restore_temp';
            if (!Storage::disk('local')->exists($restorePath)) {
                Storage::disk('local')->makeDirectory($restorePath);
            }
            
            $restoreDir = storage_path('app/' . $restorePath);

            // Bersihkan folder sementara jika ada
            $this->cleanDirectory($restoreDir);

            // Extract ZIP file by file (more reliable than extractTo)
            $zip = new \ZipArchive;
            if ($zip->open($zipPath) !== true) {
                throw new \Exception('Gagal membuka file ZIP');
            }
            
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $filename = $zip->getNameIndex($i);
                $targetPath = $restoreDir . '/' . $filename;
                
                if (substr($filename, -1) === '/') {
                    @mkdir($targetPath, 0755, true);
                    continue;
                }
                
                $parentDir = dirname($targetPath);
                if (!is_dir($parentDir)) {
                    @mkdir($parentDir, 0755, true);
                }
                
                $content = $zip->getFromIndex($i);
                if ($content !== false) {
                    file_put_contents($targetPath, $content);
                }
            }
            $zip->close();

            $sqlFile = $restoreDir . '/database.sql';
            if (!file_exists($sqlFile)) {
                throw new \Exception('File database.sql tidak ditemukan di backup');
            }

            // Restore Database (Cross-platform)
            $this->restoreDatabase($sqlFile);

            // Restore Dokumen
            $sourceDocs = $restoreDir . '/documents';
            $targetDocs = storage_path('app/public/documents');

            if (file_exists($sourceDocs)) {
                // Ensure target directory exists
                if (!is_dir($targetDocs)) {
                    @mkdir($targetDocs, 0755, true);
                }
                $this->copyFolder($sourceDocs, $targetDocs);
            }

            // Log aktivitas
            $this->logAktivitas('Restore', 'Melakukan restore sistem dari riwayat backup: ' . basename($backup->lokasi_file));

            // Bersihkan folder sementara
            $this->deleteDirectory($restoreDir);

            return redirect()->route('backup.index')->with('success', 'Restore sistem berhasil');
        } catch (\Exception $e) {
            return redirect()->route('backup.index')->with('error', 'Restore gagal: ' . $e->getMessage());
        }
    }

    /**
     * Log aktivitas backup/restore
     */
    private function logAktivitas(string $jenis, string $deskripsi): void
    {
        try {
            LogAktivitas::create([
                'id_user' => auth()->user()->id_user ?? null,
                'waktu_aktivitas' => now(),
                'jenis_aktivitas' => $jenis,
                'deskripsi' => $deskripsi,
            ]);
        } catch (\Exception $e) {
            // Silently fail - don't interrupt backup/restore process
        }
    }

    /** =========================
     * HELPER FUNCTIONS
     ========================= */

    /**
     * Restore database from SQL file (cross-platform)
     * Works on both Windows (XAMPP) and Linux (shared hosting)
     */
    private function restoreDatabase(string $sqlFile): void
    {
        $sql = file_get_contents($sqlFile);
        
        if ($sql === false) {
            throw new \Exception('Gagal membaca file SQL');
        }

        // Tabel yang tidak boleh di-restore (agar session tetap aktif)
        $skipTables = ['sessions', 'cache', 'cache_locks', 'backup', 'log_aktivitas'];

        // Split SQL statements by semicolon (handle multi-line statements)
        $statements = array_filter(
            array_map('trim', preg_split('/;[\r\n]+/', $sql)),
            fn($s) => !empty($s)
        );

        // Disable foreign key checks for restore
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        $errors = [];
        
        foreach ($statements as $statement) {
            $trimmed = trim($statement);
            if (empty($trimmed)) continue;
            
            // Skip SET FOREIGN_KEY_CHECKS as we handle it separately
            if (stripos($trimmed, 'SET FOREIGN_KEY_CHECKS') !== false) continue;
            
            // Skip statements yang mempengaruhi tabel tertentu (sessions, cache, dll)
            $shouldSkip = false;
            foreach ($skipTables as $skipTable) {
                // Match: TRUNCATE TABLE `sessions`, INSERT INTO `sessions`, etc
                if (preg_match('/\b(TRUNCATE\s+TABLE|INSERT\s+INTO|UPDATE|DELETE\s+FROM)\s+`?' . $skipTable . '`?/i', $trimmed)) {
                    $shouldSkip = true;
                    break;
                }
            }
            
            if ($shouldSkip) continue;
            
            try {
                DB::unprepared($trimmed);
            } catch (\Exception $e) {
                // Log error but continue with other statements
                $errors[] = $e->getMessage();
            }
        }
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        
        if (!empty($errors)) {
            throw new \Exception('Beberapa query gagal: ' . implode('; ', array_slice($errors, 0, 3)));
        }
    }

    private function uploadToGoogleDrive(string $filePath, string $fileName)
    {
        $token = session('google_drive_token');

        if (!$token) {
            return false;
        }

        $client = new Client();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setAccessToken($token);

        // refresh token otomatis
        if ($client->isAccessTokenExpired()) {
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
                session(['google_drive_token' => $client->getAccessToken()]);
            }
        }

        $service = new Drive($client);

        $fileMetadata = new DriveFile([
            'name' => $fileName,
            // 'parents' => ['1J6Gty5kgq1Bm0HQZ2TrcwPH87Wn3umrE'] // akun simardas
            'parents' => ['1BoHRF5PUbtX_tdcXVb6dIsdRnyI-lctZ'] // akun student
        ]);

        $service->files->create(
            $fileMetadata,
            [
                'data' => file_get_contents($filePath),
                'mimeType' => 'application/zip',
                'uploadType' => 'multipart',
            ]
        );
        return true;
    }
    private function dumpDatabase($outputFile)
    {
        $tables = DB::select('SHOW TABLES');
        $dbName = DB::getDatabaseName();
        $sql = "SET FOREIGN_KEY_CHECKS=0;\n";

        foreach ($tables as $tableObj) {
            $table = array_values((array)$tableObj)[0];

            if (in_array($table, $this->excludeTables)) {
                continue;
            }

            $sql .= "TRUNCATE TABLE `$table`;\n";

            $rows = DB::table($table)->get();
            foreach ($rows as $row) {
                $values = array_map(fn($v) => DB::getPdo()->quote($v), (array)$row);
                $sql .= "INSERT INTO `$table` VALUES (" . implode(',', $values) . ");\n";
            }
        }

        $sql .= "SET FOREIGN_KEY_CHECKS=1;";
        file_put_contents($outputFile, $sql);
    }

    private function copyDirectory($src, $dst)
    {
        mkdir($dst, 0777, true);
        foreach (scandir($src) as $file) {
            if ($file === '.' || $file === '..') continue;
            $srcPath = "$src/$file";
            $dstPath = "$dst/$file";
            is_dir($srcPath)
                ? $this->copyDirectory($srcPath, $dstPath)
                : copy($srcPath, $dstPath);
        }
    }

    private function deleteDirectory($dir)
    {
        if (!is_dir($dir)) return;
        foreach (scandir($dir) as $file) {
            if ($file === '.' || $file === '..') continue;
            $path = "$dir/$file";
            is_dir($path) ? $this->deleteDirectory($path) : unlink($path);
        }
        rmdir($dir);
    }

    /**
     * Clean all files in a directory without removing the directory itself
     */
    private function cleanDirectory($dir)
    {
        if (!is_dir($dir)) return;
        foreach (scandir($dir) as $file) {
            if ($file === '.' || $file === '..') continue;
            $path = "$dir/$file";
            is_dir($path) ? $this->deleteDirectory($path) : unlink($path);
        }
    }

    private function zipFolder($folder, ZipArchive $zip, $base = '')
    {
        foreach (scandir($folder) as $file) {
            if ($file === '.' || $file === '..') continue;
            $path = "$folder/$file";
            $local = ltrim("$base/$file", '/');
            is_dir($path)
                ? ($zip->addEmptyDir($local) && $this->zipFolder($path, $zip, $local))
                : $zip->addFile($path, $local);
        }
    }
}
