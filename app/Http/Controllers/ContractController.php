<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Patient;
use App\Models\User;
use App\Models\Contract;
use App\Models\Plan;
use App\Models\PatientPlan;
use App\Models\ContractLog;
use App\Helpers\Helper;
use \Illuminate\Support\Str;
use PDF;
use Closure;

class ContractController extends Controller
{
    public function generate($patient_id, Request $request){
        $patient = Patient::where('id', $patient_id)->first();
        $patient_cpf_formatted = Helper::mask($patient->cpf, '###.###.###-##');
        $patient->cep = Helper::mask($patient->cep, '#####-###');

        $patientPlan = PatientPlan::where('id', $request->patient_plan_id)->with('plan')->first();

        if (!$patientPlan) {
            return response()->json(
                'Ops. Plano não encontrado!', 404
            );
        }

        $doctor = User::where('id', $patientPlan->doctor_id)->first();

        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

        $month = strftime('%B');
        
        $plan = $patientPlan->plan;

        $contract_id = Str::uuid();

        $pdf = PDF::setPaper('a4');
        $pdf = $pdf->loadView('contract.contract-layout', compact('patient', 'patient_cpf_formatted', 'plan', 'doctor', 'month'));
        $file_name = $contract_id . '_' . $patient->nome . '_' . $patient->cpf . '.pdf';
        file_put_contents('contracts_pdf/' . $file_name, $pdf->output());
        $file = file_get_contents(base_path('public/contracts_pdf/') . $file_name);
        $base64 = base64_encode($file);

        $contract = Contract::create([
            'id' => $contract_id,
            'patient_plan_id' => $request->patient_plan_id,
            'base64' => $base64,
            'file_name' => $file_name,
        ]);

        if(!$contract){
            return response()->json('Houve algum erro ao gerar o contrato');
        }

        return response()->json(
            $base64,
        );
    }

    public function get_contractor_pdf($contract_id){
        $contract = Contract::where('id', $contract_id)->first();

        if(!$contract){
            return response()->json([
                'error' => 'Contrato não encontrado'
            ], 404);
        };

        $file_name = $contract->file_name;
        $file_path = base_path('public/contracts_pdf/' . $file_name);
        $file = file_get_contents(base_path('public/contracts_pdf/') . $file_name);
        $base64 = base64_encode($file);
        return response()->json(
            $base64,
        );
    }

    public function edit_contract($contractId, Request $request){

        date_default_timezone_set('America/Sao_Paulo');

        $contractJoin = DB::table('contracts')
        ->join('patients_plans', 'contracts.patient_plan_id', '=', 'patients_plans.id')
        ->where('contracts.id', $contractId)
        ->select('contracts.*')
        ->get();

        $contractId = '';
        foreach($contractJoin as $contract) {
            $contractId = $contract->id;
        };

        $contract = Contract::where('id', $contractId)->with('patient_plan')->first();
        $patient = Patient::where('id', $contract->patient_plan->patient_id)->first();
        $plan = Plan::where('id', $contract->patient_plan->plan_id)->first();
        $doctor = User::where('id', $contract->patient_plan->doctor_id)->first();

        if($request->doctor_id != $plan->id) {
            $doctor = User::where('id', $request->doctor_id)->first();
        }

        if($request->plan_id != $plan->id){
            $plan = Plan::where('id', $request->plan_id)->first();
        }

        $contract->patient_plan->doctor_id = $request->doctor_id;
        $contract->patient_plan->plan_id = $request->plan_id;
        $contract->patient_plan->total_value = $plan->value;

        if($request->discount > 0 || $request->discount != null){
            $value_total = ($plan->value * $request->discount) / 100;
            $value_total = $plan->value - $value_total;
            $contract->patient_plan->total_value = $value_total;
        }

        $save = $contract->patient_plan->save();

        $contract_log = ContractLog::create([
            'contract_id' => $contractId,
            'date' => date("Y-m-d H:i:s"),
        ]);

        if(!$save){
            return response()->json([
                'error' => 'Houve um erro ao savar as alterações',
            ]);
        }

        $patient_cpf_formatted = Helper::mask($patient->cpf, '###.###.###-##');
        $patient->cep = Helper::mask($patient->cep, '#####-###');

        $file_name = $contract->file_name;
        
        $pdf = PDF::setPaper('a4');
        $pdf = $pdf->loadView('contract.contract-layout', compact('patient', 'patient_cpf_formatted', 'plan', 'doctor'));
        file_put_contents('contracts_pdf/' . $file_name, $pdf->output());
        $file = file_get_contents(base_path('public/contracts_pdf/') . $file_name);
        $base64 = base64_encode($file);

        return response()->json(
            $base64,
        );
    }

}