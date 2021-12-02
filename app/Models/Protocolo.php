<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Protocolo extends Model
{
    protected $fillable = [
        'descricao',
    ];

    public function Calendar(){
        return $this->belongsTo(Agender::class);
    }

    public function showId($id){
        return $this->where('id', $id);
    }
} 