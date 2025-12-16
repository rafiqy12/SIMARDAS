<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    protected $table = 'dokumen';
    protected $primaryKey = 'id_dokumen';
    public $timestamps = false;

    protected $fillable = [
        'judul',
        'deskripsi',
        'kategori',
        'tipe_file',
        'tanggal_upload',
        'path_file',
        'ukuran_file',
        'id_user'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function barcode()
    {
        return $this->hasOne(\App\Models\Barcode::class, 'id_dokumen', 'id_dokumen');
    }

    public function getFileSizeAttribute()
    {
        if (is_null($this->ukuran_file)) {
            return '-';
        }

        $size = $this->ukuran_file;

        if ($size >= 1048576) {
            return round($size / 1048576, 2) . ' MB';
        } elseif ($size >= 1024) {
            return round($size / 1024, 2) . ' KB';
        }

        return $size . ' B';
    }
}
