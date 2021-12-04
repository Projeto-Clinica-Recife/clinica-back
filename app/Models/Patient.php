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
}
