<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barcode extends Model
{
    protected $table = 'barcode';
    protected $primaryKey = 'id_dokumen';
    public $timestamps = false; 

    protected $fillable = [
        'kode_barcode',
        'id_dokumen'
    ];

    public function dokumen()
    {
        return $this->belongsTo(Dokumen::class, 'id_dokumen');
    }
}
