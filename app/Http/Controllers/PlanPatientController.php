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
    public function store($patientId, Request $request){

        $plan = Plan::find($request->plan_id);

        $plan_days = $plan->period * 30;
        $venciment = date("Y-m-d", strtotime('+'.$plan_days . ' days'));

        $value_total = $plan->value;
        // Verifica se tem desconto e aplica sobre o valor do plano
        if ($request->discount > 0) {
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

    public function get_plans_patient($patientId){
        $patient_plan = DB::table('patients')
        ->join('patients_plans', 'patients.id', '=', 'patients_plans.patient_id')
        ->join('plans', 'plans.id', 'patients_plans.plan_id')
        ->join('contracts', 'patients_plans.id', '=', 'contracts.patient_plan_id')
        ->select('patients.nome as patient_name')
        ->addSelect('patients_plans.id as patient_plan_id', 'patients_plans.form_of_payment', 'patients_plans.discount', 'patients_plans.dueDate as vencimento')
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