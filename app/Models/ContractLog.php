<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Support\Str;

class ContractLog extends Model
{
    protected $table = 'contracts_logs';

    protected $fillable = [
        'contract_id',
        'date',
    ];

    public function contract(){
        return $this->belongsTo(Cotract::class);
    }

}