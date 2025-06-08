<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TimAudit extends Model
{   
    use SoftDeletes;
    protected $fillable=[
        'id_pka',
        'id_pegawai',
        'is_pic'
    ];

    public function pka(){
        return $this->belongsTo(Pka::class,'id_pka','id');
    }

    public function pegawai(){
        return $this->belongsTo(Pegawai::class,'id_pegawai','id');
    }

    public function scopeFindByPka($query,$id_pka){
        return $query->whereIdPka($id_pka);
    }
}
