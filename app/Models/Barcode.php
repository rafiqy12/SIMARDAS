<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barcode extends Model
{
    protected $table = 'barcode';

    protected $fillable = [
        'id_dokumen',
        'kode_barcode',
        'tanggal_generate',
    ];

    public $timestamps = false;
}
