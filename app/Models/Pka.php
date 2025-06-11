<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pka extends Model
{
    use SoftDeletes;

    protected $fillable=[
        'inserted_by',
        'id_surat_tugas',
        'landasan_audit',
        'tujuan_audit',
        'sasaran_audit',
        'lingkup_audit',
        'gambaran_audit',
        'data_awal',
    ];

    public function suratTugas(){
        return $this->belongsTo(SuratTugas::class,'id_surat_tugas','id');
    }

    public function timAudit(){
        return $this->hasMany(TimAudit::class,'id_pka','id');
    }

    public function daftarHadir(){
        return $this->hasMany(DaftarHadir::class,'id_pka','id');
    }

    public function kertasKerja(){
        return $this->hasMany(KertasKerja::class,'id_pka','id');
    }

    public function lha(){
        return $this->hasOne(Lha::class,'id_pka','id');
    }

}
