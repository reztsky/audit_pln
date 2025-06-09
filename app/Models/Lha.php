<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lha extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'inserted_by',
        'id_pka',
        'judul',
        'ringkasan',
        'status',
        'komentar',
        'tanggal_selesai',
    ];

    // Relasi ke PKA
    public function pka()
    {
        return $this->belongsTo(Pka::class, 'id_pka');
    }

    // Relasi ke User (pembuat laporan)
    public function creator()
    {
        return $this->belongsTo(User::class, 'inserted_by');
    }

    // Relasi ke Kertas Kerja (jika setiap LHA punya banyak kertas kerja)
    public function kertasKerja()
    {
        return $this->hasMany(KertasKerja::class, 'lha_id');
    }

    // Scope untuk status
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
