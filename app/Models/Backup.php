<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Backup extends Model
{
    protected $table = 'backup';
    protected $primaryKey = 'id_backup';
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'tanggal_backup',
        'lokasi_file',
        'status',
        'ukuran_file'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
