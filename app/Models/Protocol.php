<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Protocol extends Model
{
    protected $fillable = [
        'descricao',
    ];

    public function Calendar(){
        return $this->belongsTo(Agender::class);
    }

} 