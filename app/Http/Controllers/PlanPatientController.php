<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PatientPlan;
use App\Models\Patient;
use App\Models\Plan;
use Validator;

class PlanPatientController extends Controller
{
    public function store($patientId, $planId, Request $request){

        $plan = Plan::find($planId);

        $plan_days = $plan->period * 30;
        $venciment = date("Y-m-d", strtotime($plan_days . ' days'));

        $patient_plan = PatientPlan::create([
            'patient_id' => $request->patientId,
            'plan_id' => $request->planId,
            'form_of_payment' => $request->form_of_payment,
            'discount' => $request->discount,
            'dueDate' => $venciment,
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

    public function get_plan_patient($patientId){
        $patient_plan = DB::table('patients')
        ->join('patients_plans', 'patients.id', '=', 'patients_plans.patient_id')
        ->join('plans', 'plans.id', 'patients_plans.plan_id')
        ->select('patients.nome as patient_name')
        ->addSelect('patients_plans.form_of_payment', 'patients_plans.discount', 'patients_plans.dueDate as Vencimento')
        ->addSelect('plans.description', 'plans.period', 'plans.value')
        ->where('patients.id', '=', $patientId)
        ->get();

        return $patient_plan;
    }

}