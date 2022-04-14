<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Model
{

    use HasFactory;

    protected $fillable = [
        'nome',
        'data_nascimento',
        'cpf',
        'rg',
        'telephone',
        'dispatcher',
        'email',
        'cep',
        'rua',
        'numero',
        'bairro',
        'cidade',
        'estado',
        'complemento',
        'ponto_referencia',
        'nationality',
        'profession',
        'marital_status',
        'signature',
    ];

    public function contract(){
        return $this->hasOne(Contract::class);
    }

    public function agender(){
        return $this->hasMany(Agender::class);
    }

    public function query_patient(){
        return $this->hasMany(QueryPatient::class);
    }

    public function patient_plan(){
        return $this->hasMany(PatientPlan::class);
    }
}
