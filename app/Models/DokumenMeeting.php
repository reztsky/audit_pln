<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DokumenMeeting extends Model
{
    use SoftDeletes;
    protected $fillable=[
        'id_surat_tugas',
        'inserted_by',
        'jenis_dokumen',
        'path_dokumen'
    ];

    public function suratTugas(){
        return $this->belongsTo(SuratTugas::class,'id_surat_tugas','id');
    }

    public function user(){
        return $this->belongsTo(User::class,'inserted_by','id');
    }
}
