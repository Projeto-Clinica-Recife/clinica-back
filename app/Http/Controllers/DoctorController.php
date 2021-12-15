<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\PatientPlan;

class DoctorController extends Controller
{
    public function getDoctors(){
        $doctores = User::where('type_user', 'doctor')->get();
        if($doctores->count() <= 0){
            return response()->json([
                'message' => 'Ops. Nenhum médico cadastrado na Base de Dados.',
            ]);
        };

        // $doctores = DB::table('users')
        // ->join('user_information', 'user_information.user_id', '=', 'users.id')
        // ->where('type_user', 'admin')->get();

        return response()->json(
            $doctores,
        200);
    }

    public  function show($id){
        $query = User::find($id);
        if(!$query){
        $queryTwo = User::where('nome','like','%'.$id.'%')
        ->orWhere('cpf','=', $id)
        ->where('type_user','=','doctor')
        ->get();
        if (count($queryTwo) > 0 ) {
            return response()->json($queryTwo, 200);
        }else if (count($queryTwo) == 0 ) {
            return response()->json(0, 200);
        }else{
             $data = [
                'message' => 'Erro ao consultar'
            ];
            return response()->json($data, 200);
        }
     }else{
        return response()->json($query, 200);
     }
        
    }

    public function get_linked_plans($doctorId){
        $plans = PatientPlan::
        where('doctor_id', $doctorId)
        ->with('plan')
        ->get();

        collect($plans)->map(function($plan){
            
        });

        return $plans;
    }
}