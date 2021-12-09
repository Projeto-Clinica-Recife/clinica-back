<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prescription extends Model
{

    use HasFactory;

    protected $fillable = [
        'id',
        'agender_id',
        'base64',
        'file_name',
    ];

    public function agender(){
        return $this->belongsTo(Agender::class);
    }

}