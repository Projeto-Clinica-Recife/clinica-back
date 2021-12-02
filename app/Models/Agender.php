<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agender extends Model
{
    protected $fillable = [
        'date',
        'hour',
        // 'protocols_id',
        'doctor_id',
        'patient_id',
    ];

    public function doctor(){
        return $this->belongsTo(User::class,'doctor_id');
    }
    

} 