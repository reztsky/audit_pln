<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LhaLog extends Model
{
    use SoftDeletes;

    protected $fillable = ['lha_id', 'inserted_by', 'action', 'catatan'];
     protected $appends = ['formated_date'];

    public function lha()
    {
        return $this->belongsTo(Lha::class, 'lha_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'inserted_by', 'id');
    }

    public function getFormatedDateAttribute(){
        return $this->created_at->translatedFormat('d F Y H:i');
    }
}
