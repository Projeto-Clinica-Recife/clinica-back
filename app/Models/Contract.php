<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Support\Str;

class Contract extends Model
{
    protected $fillable = [
        'id',
        'patient_plan_id',
        'file_name',
    ];

    public function patient(){
        return $this->belongsTo(Patient::class);
    }
}