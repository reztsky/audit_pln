<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KertasKerja extends Model
{
    use SoftDeletes;

    protected $casts = [
        'tanggal' => 'date'
    ];

    protected $appends = ['tanggal_formatted'];

    protected $fillable = [
        'inserted_by',
        'id_pka',
        'id_lha',
        'kategori_temuan',
        'kontrol',
        'tanggal',
        'temuan',
        'ofi',
        'keterangan_tambahan',
        'dokumen_dukung',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'inserted_by', 'id');
    }

    public function pka()
    {
        return $this->belongsTo(Pka::class, 'id_pka', 'id');
    }

    public function lha(){
        return $this->belongsTo(Lha::class,'id_lha','id');
    }

    public function scopeFindByLha($query,$id_lha){
        return $query->where('id_lha',$id_lha);
    }

    public function scopeLhaNotNull($query){
        return $query->whereNotNull('id_lha');
    }

    public function scopeFindByPka($query, $idpka)
    {
        return $query->where('id_pka', $idpka);
    }

    public function getTanggalFormattedAttribute()
    {
        return $this->tanggal->translatedFormat('d F Y');
    }
}
