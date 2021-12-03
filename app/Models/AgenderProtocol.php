<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgenderProtocol extends Model
{
    protected $fillable = [
        'status',   
        'agender_id',
        'protocol_id',
    ];

    public function protocol(){
        return $this->belongsTo(Protocol::class,'protocol_id');
    }


    

} 