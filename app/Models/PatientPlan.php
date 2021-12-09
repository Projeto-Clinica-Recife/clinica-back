<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientPlan extends Model
{
    protected $fillable = [
        'patient_id',
        'plan_id',
        'form_of_payment',
    ];
}