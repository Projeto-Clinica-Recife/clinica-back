<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientPlan extends Model
{

    protected $table = 'patients_plans';

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'plan_id',
        'form_of_payment',
        'discount',
        'observation',
        'dueDate',
        'total_value',
    ];

    public function patient(){
        return $this->belongsTo(Patient::class);
    }

    public function doctor(){
        return $this->belongsTo(Patient::class);
    }

    public function plan(){
        return $this->belongsTo(Plan::class);
    }
}