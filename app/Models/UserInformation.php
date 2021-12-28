<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserInformation extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'telephone',
        'crm',
        'crm_state',
        'logo_doctor_file_name',
        'user_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
