<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TindakLanjutLha extends Model
{
    protected $fillable=[
        'id_lha',
        'inserted_by',
        'tindak_lanjut',
        'eviden_path',
        'status'
    ];

    public function lha(){
        return $this->belongsTo(Lha::class,'id_lha','id');
    }
}
