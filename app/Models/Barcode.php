<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barcode extends Model
{
    protected $table = 'barcode';

    protected $fillable = [
        'kode_barcode',
        'id_dokumen'
    ];
    public $timestamps = false; 

    public function dokumen()
    {
        return $this->belongsTo(Dokumen::class, 'id_dokumen');
    }
}
