<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'nome',
        'data_nascimento',
        'cpf',
        'rg',
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
        'contracted_plan',
        'signature',
    ];

    public function contract(){
        return $this->hasOne(Contract::class);
    }

    public function query_patient(){
        return $this->hasMany(QueryPatient::class);
    }
}
