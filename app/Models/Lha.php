<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

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

    protected $appends=[
        'formatedAction'
    ];

    public function LhaLog(){
        return $this->hasMany(LhaLog::class,'lha_id','id');
    }

    public function tindakLanjutLha(){
        return $this->hasOne(TindakLanjutLha::class,'id_lha','id');
    }

    // Relasi ke User (pembuat laporan)
    public function user()
    {
        return $this->belongsTo(User::class, 'inserted_by');
    }

    // Relasi ke Kertas Kerja (jika setiap LHA punya banyak kertas kerja)
    public function kertasKerja()
    {
        return $this->hasMany(KertasKerja::class,'id_lha','id');
    }

    // Scope untuk status
    public function scopeStatus($query, $status)
    {
        return $query->whereIn('status', $status);
    }

    public function getFormatedActionAttribute(){
        return Str::title(str_replace('_', ' ', $this->action));
    }
}
