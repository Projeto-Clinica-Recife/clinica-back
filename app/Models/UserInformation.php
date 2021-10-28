<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserInformation extends Model
{
    protected $fillable = [
        'crm',
        'telephone',
        'user_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
