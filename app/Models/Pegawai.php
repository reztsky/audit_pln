<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $fillable=[
        'nama',
        'nip',
        'jabatan'
    ];

    public function scopeStafAuditor($query){
        return $query->whereJabatan('Staf Auditor');
    }

    public function scopeTimAudit($query){
        return $query->whereIn('jabatan',[
            'Atasan Auditee',
            'Staf Auditee'
        ])->orderBy('jabatan');
    }
}
