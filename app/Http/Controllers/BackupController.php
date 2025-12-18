<?php

namespace App\Http\Controllers;

use App\Models\Backup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use ZipArchive;

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
        $zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        $this->zipFolder($basePath, $zip);
        $zip->close();

        /** =========================
         * 4️⃣ SIMPAN KE DB
         ========================= */
        Backup::create([
            'id_user' => auth()->user()->id_user,
            'tanggal_backup' => now(),
            'lokasi_file' => "backup/{$backupName}.zip",
            'status' => 'success',
            'ukuran_file' => filesize($zipPath),
        ]);

        /** =========================
         * 5️⃣ CLEAN TEMP
         ========================= */
        $this->deleteDirectory($basePath);

        return back()->with('success', 'Backup berhasil dibuat');
    }

    /**
     * DOWNLOAD BACKUP
     */
    public function download($id)
    {
        $backup = Backup::findOrFail($id);
        $path = storage_path('app/' . $backup->lokasi_file);

        abort_if(!file_exists($path), 404);

        return response()->download($path);
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
             * 3️⃣ RESTORE DATABASE
             * ========================== */
            $db = config('database.connections.mysql');
            $mysql = 'C:\xampp\mysql\bin\mysql';

            $command = "\"$mysql\" --user={$db['username']} --password={$db['password']} {$db['database']} < \"$sqlFile\"";
            exec($command, $output, $result);

            if ($result !== 0) {
                throw new \Exception('Restore database gagal');
            }

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

            // Restore Database
            $db = config('database.connections.mysql');
            $mysql = 'C:\xampp\mysql\bin\mysql'; // sesuaikan dengan path MySQL

            $command = "\"$mysql\" --user={$db['username']} --password={$db['password']} {$db['database']} < \"$sqlFile\"";
            exec($command, $output, $result);

            if ($result !== 0) {
                throw new \Exception('Restore database gagal');
            }

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
