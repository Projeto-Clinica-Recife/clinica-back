<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Agender extends Model
{

    use HasFactory;
    
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

    public function protocols(){
        return $this->hasMany(AgenderProtocol::class);
    }
    

} 