<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QueryPatient extends Model
{
    protected $fillable = [
        'doctor_id',
        'patient_id',
        'plaint',
        'observation',
        'protocols'
    ];

   


    

} 