<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PegawaiHasUser extends Model
{
    protected $fillable=[
        'id_pegawai',
        'id_user'
    ];

    public function pegawai(){
        return $this->belongsTo(Pegawai::class,'id_pegawai','id');
    }

    public function user(){
        return $this->belongsTo(User::class,'id_user','id');
    }
}
