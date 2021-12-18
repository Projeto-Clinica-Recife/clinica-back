<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\PatientPlan;
use Illuminate\Support\Str;

class DoctorController extends Controller
{
    public function getDoctors(){
        $doctores = User::where('type_user', 'doctor')->with('user_information')->get();
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
        $search = $replaced = Str::replace('%20', ' ', $id);
        if(!$query){
        $queryTwo = User::where('name','like','%'.$search.'%')
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

    public  function showById($id){
        // $query = User::find($id)->with('user_information')->first();
        $query = User::with('user_information')->where('id',$id)->first();
        return response()->json($query, 200);

    }

    public function get_linked_plans($doctorId){

        $plans = DB::table('users')
        ->join('patients_plans', 'users.id', '=', 'patients_plans.doctor_id')
        ->join('plans', 'plans.id', 'patients_plans.plan_id')
        ->join('patients', 'patients_plans.patient_id', '=', 'patients.id')
        ->join('contracts', 'patients_plans.id', '=', 'contracts.patient_plan_id')
        ->where('users.id', '=', $doctorId)
        ->select('patients.nome as patient_name')
        ->addSelect('patients_plans.id as patient_plan_id', 'patients_plans.form_of_payment', 'patients_plans.discount', 'patients_plans.dueDate as vencimento', 'patients_plans.payment_status', 'patients_plans.created_at as inicio')
        ->addSelect('plans.description', 'plans.period', 'plans.value', 'plans.id as plan_id')
        ->addSelect('contracts.id as contract_id')
        ->get();

        foreach($plans as $plan){
            $plan->value = number_format($plan->value, 2, ',', '.');
        }

        return response()->json($plans);
    }
}