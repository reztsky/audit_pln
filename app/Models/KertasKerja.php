<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KertasKerja extends Model
{
    use SoftDeletes;

    protected $fillable=[
        'inserted_by',
        'id_pka',
        'id_lha',
        'kontrol',
        'unit',
        'bidang',
        'tanggal',
        'temuan',
        'ofi',
        'keterangan_tambahan',
        'dokumen_dukung',
    ];

    public function pka(){
        return $this->belongsTo(Pka::class,'id_pka','id');
    }

    public function lha(){
        // return $this->belongsTo(Pka::class,'id_pka','id');
    }
}
