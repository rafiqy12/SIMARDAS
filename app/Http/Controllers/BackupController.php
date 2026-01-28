<?php

namespace App\Http\Controllers;

use App\Models\Backup;
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
    /** TABEL YANG TIDAK DIBACKUP */
    private array $excludeTables = [
        'backup',
        'backup_detail',
        'log_aktivitas',
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
            $basePath = storage_path("app/backup/{$backupName}");

            if (!is_dir($basePath)) {
                mkdir($basePath, 0777, true);
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
             * 5️⃣ CLEAN TEMP
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
            $backupDir = storage_path('app/restore');
            if (!file_exists($backupDir)) {
                mkdir($backupDir, 0755, true);
            }

            /** ==========================
             * 1️⃣ SIMPAN ZIP
             * ========================== */
            $zipPath = $backupDir . '/' . time() . '.zip';
            $request->file('backup_zip')->move($backupDir, basename($zipPath));

            /** ==========================
             * 2️⃣ EXTRACT ZIP
             * ========================== */
            $zip = new \ZipArchive;
            if ($zip->open($zipPath) !== true) {
                throw new \Exception('Gagal membuka file ZIP');
            }

            $zip->extractTo($backupDir);
            $zip->close();

            $sqlFile = $backupDir . '/database.sql';
            if (!file_exists($sqlFile)) {
                throw new \Exception('File database.sql tidak ditemukan');
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
            unlink($sqlFile);

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
            $restoreDir = storage_path('app/restore_temp');

            // Bersihkan folder sementara jika ada
            $this->deleteDirectory($restoreDir);
            mkdir($restoreDir, 0755, true);

            // Extract ZIP
            $zip = new \ZipArchive;
            if ($zip->open($zipPath) !== true) {
                throw new \Exception('Gagal membuka file ZIP');
            }
            $zip->extractTo($restoreDir);
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
                $this->copyFolder($sourceDocs, $targetDocs);
            }

            // Bersihkan folder sementara
            $this->deleteDirectory($restoreDir);

            return redirect()->route('backup.index')->with('success', 'Restore sistem berhasil');
        } catch (\Exception $e) {
            return redirect()->route('backup.index')->with('error', 'Restore gagal: ' . $e->getMessage());
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

        // Split SQL statements by semicolon (handle multi-line statements)
        $statements = array_filter(
            array_map('trim', preg_split('/;[\r\n]+/', $sql)),
            fn($s) => !empty($s)
        );

        DB::beginTransaction();
        
        try {
            foreach ($statements as $statement) {
                if (!empty(trim($statement))) {
                    DB::unprepared($statement);
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('Restore database gagal: ' . $e->getMessage());
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
