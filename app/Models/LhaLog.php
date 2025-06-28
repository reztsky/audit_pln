<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class LhaLog extends Model
{
    use SoftDeletes;

    protected $fillable = ['lha_id', 'inserted_by', 'action', 'catatan'];
    protected $appends = ['formated_date','formatedAction'];

    public function lha()
    {
        return $this->belongsTo(Lha::class, 'lha_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'inserted_by', 'id');
    }

    public function scopeFindByLha($query, $id_lha)
    {
        return $query->where('lha_id', $id_lha);
    }

    public function getFormatedDateAttribute()
    {
        return $this->created_at->translatedFormat('d F Y H:i');
    }

    public function getFormatedActionAttribute()
    {
        return Str::title(str_replace('_', ' ', $this->action));
    }
}
