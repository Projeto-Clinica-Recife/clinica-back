<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class DoctorController extends Controller
{
    public function getDoctors(){
        $doctores = User::where('type_user', 'doctor')->get();
        if($doctores->count() <= 0){
            return response()->json([
                'message' => 'Ops. Nenhum médico cadastra na Base de Dados.',
            ]);
        };

        return response()->json(
            $doctores,
        200);
    }
}