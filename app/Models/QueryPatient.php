<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QueryPatient extends Model
{
    protected $fillable = [
        'doctor_id',
        'patient_id',
        'agender_protocol_id',
        'plaint',
        'observation',
        'protocols'
    ];

    public function patient(){
        return $this->belongsTo(Patient::class);
    }

    public function doctor(){
        return $this->belongsTo(Patient::class);
    }
    

} 