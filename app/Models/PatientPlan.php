<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientPlan extends Model
{

    protected $table = 'patients_plans';

    protected $fillable = [
        'patient_id',
        'plan_id',
        'form_of_payment',
        'discount',
        'dueDate'
    ];

    public function patient(){
        return $this->belongsTo(Patient::class);
    }
}