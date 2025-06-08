<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratTugas extends Model
{
    protected $casts=[
        'tanggal_audit'=>'date'
    ];
    
    protected $fillable=[
        'inserted_by',
        'pic_id_pegawai',
        'judul_audit',
        'tanggal_audit',
        'lokasi_audit',
        'surat_tugas',
    ];

    public function pegawai(){
        return $this->belongsTo(Pegawai::class,'pic_id_pegawai','id');
    }
}
