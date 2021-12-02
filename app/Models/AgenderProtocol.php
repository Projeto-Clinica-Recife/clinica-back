<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgenderProtocol extends Model
{
    protected $fillable = [      
        'agender_id',
        'protocol_id',
    ];

    public function doctor(){
        return $this->belongsTo(User::class,'doctor_id');
    }
    

} 