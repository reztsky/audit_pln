<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lha extends Model
{
    use SoftDeletes;

    protected $casts=[
        'id_kertas_kerja'=>'array'
    ];

    protected $fillable = [
        'inserted_by',
        'id_kertas_kerja',
        'action'
    ];

    public function LhaLog(){
        return $this->hasMany(LhaLog::class,'lha_id','id');
    }

    // Relasi ke User (pembuat laporan)
    public function user()
    {
        return $this->belongsTo(User::class, 'inserted_by');
    }

    // Relasi ke Kertas Kerja (jika setiap LHA punya banyak kertas kerja)
    public function kertasKerja()
    {
        return KertasKerja::whereIn('id', $this->item_ids ?? []);
    }

    // Scope untuk status
    public function scopeStatus($query, $status)
    {
        return $query->whereIn('status', $status);
    }
}
