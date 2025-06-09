<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DaftarHadir extends Model
{
    use SoftDeletes;

    protected $casts=[
        'tanggal_meeting'=>'date'
    ];

    protected $appends = ['tanggal_formatted'];
    
    protected $fillable = [
        'inserted_by',
        'id_pka',
        'tanggal_meeting',
        'lokasi_meeting',
        'daftar_hadir'
    ];

    public function pka(){
        return $this->belongsTo(Pka::class,'id_pka','id');
    }

    public function scopeFindByPka($query,$idpka){
        return $query->where('id_pka',$idpka);
    }

    public function getTanggalFormattedAttribute() {
        return $this->tanggal_meeting->translatedFormat('d F Y');
    }
}
