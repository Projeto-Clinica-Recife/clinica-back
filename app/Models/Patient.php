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
        'email',
        'cep',
        'rua',
        'numero',
        'bairro',
        'cidade',
        'estado',
        'complemento',
        'ponto_referencia',
        'signature',
    ];
}
