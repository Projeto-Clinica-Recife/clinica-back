<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PatientPlan;
use App\Models\Patient;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Support\Str;
use Validator;

class PlanPatientController extends Controller
{
    public function store($patientId, Request $request){

        $plan = Plan::find($request->plan_id);

        $plan_days = $plan->period * 30;
        $venciment = date("Y-m-d", strtotime('+'.$plan_days . ' days'));

        $value_total = $plan->value;
        // Verifica se tem desconto e aplica sobre o valor do plano
        if ($request->discount > 0 || $request->discount != null) {
            $value_total = ($plan->value * $request->discount) / 100;
            $value_total = $plan->value - $value_total;
        }

        $patient_plan = PatientPlan::create([
            'patient_id' => $request->patientId,
            'doctor_id' => $request->doctor_id,
            'plan_id' => $request->plan_id,
            'form_of_payment' => $request->form_of_payment,
            'discount' => $request->discount,
            'dueDate' => $venciment,
            'total_value' => $value_total,
            'observation' => $request->observation,
        ]);
        
        if (!$patient_plan) {
            return response()->json([
                'message' => 'Houve algum erro ao vincular o paciente ao plano',
            ], 404);
        }

        return response()->json([
            'message' => 'Plano viculado com sucesso!',
            'patient_plan' => $patient_plan,
        ], 202);
    }

    public function search_plan_patient($item) {
        $search = $replaced = Str::replace('%20', ' ', $item);

        // $patient = Patient::where('cpf','like','%'.$search.'%')
        // ->first();
        // $plans = null;
        // if($patient){
        //     $plans = PatientPlan::where('patient_id', $patient->id)->first();
        // }

        // if($plans){
        //     return response()->json($patient);
        // }

        $patient = DB::table('patients')
        ->join('patients_plans', 'patients.id', '=', 'patients_plans.patient_id')
        ->where('nome','like','%'.$search.'%')
        ->orWhere('cpf','like','%'.$search.'%')
        ->select('patients.*')
        ->distinct()
        ->get()->toArray();

        return response()->json($patient);

    }

    public function search_plan_doctor($item){
        $search = $replaced = Str::replace('%20', ' ', $item);

        // $doctor = User::where('cpf','like','%'.$search.'%')
        // ->where('type_user', '=', 'doctor')
        // ->first();
        // $plans = null;
        // if($doctor){
        //     $plans = PatientPlan::where('doctor_id', $doctor->id)->first();
        // }

        // if($plans){
        //     return response()->json($doctor);
        // }

        $doctor = DB::table('users')
        ->join('patients_plans', 'users.id', '=', 'patients_plans.doctor_id')
        ->where('name','like','%'.$search.'%')
        ->orWhere('cpf','like','%'.$search.'%')
        ->where('type_user', '=', 'doctor')
        ->select('users.*')
        ->distinct()
        ->get()->toArray();

        return response()->json($doctor);
    }

    public function get_plans_patient($patientId){
        $patient_plan = DB::table('patients')
        ->join('patients_plans', 'patients.id', '=', 'patients_plans.patient_id')
        ->join('plans', 'plans.id', 'patients_plans.plan_id')
        ->join('contracts', 'patients_plans.id', '=', 'contracts.patient_plan_id')
        ->select('patients.nome as patient_name')
        ->addSelect('patients_plans.id as patient_plan_id', 'patients_plans.form_of_payment', 'patients_plans.discount', 'patients_plans.dueDate as vencimento', 'patients_plans.observation')
        ->addSelect('plans.description', 'plans.period', 'plans.value', 'plans.id as plan_id')
        ->addSelect('contracts.id as contract_id')
        ->where('patients.id', '=', $patientId)
        ->get();

        foreach ($patient_plan as $patient) {
            $patient->value = number_format($patient->value, 2, ',', '.');
        }

        return $patient_plan;
    }

}