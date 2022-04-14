<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model {

    protected $table = 'receipts';

    protected $fillable = [
        'client_id',
        'doctor_id',
        'type_product',
        'value',
        'form_of_payment',
        'observation',
        'payment_status',
        'value_remaining',
        'product_id',
    ];
}