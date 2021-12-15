<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Patient;
use App\Models\Contract;
use App\Models\Plan;
use App\Models\PatientPlan;
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

        $patientPlanId = PatientPlan::where('id', $request->patient_plan_id)->with('plan')->first();

        if (!$patientPlanId) {
            return response()->json(
                'Ops. Plano não encontrado!', 404
            );
        }
        
        $plan = $patientPlanId->plan;

        $contract_id = Str::uuid();

        $pdf = PDF::setPaper('a4');
        $pdf = $pdf->loadView('contract.contract-layout', compact('patient', 'patient_cpf_formatted', 'plan'));
        $file_name = $contract_id . '_' . $patient->nome . '_' . $patient->cpf . '.pdf';
        file_put_contents('contracts_pdf/' . $file_name, $pdf->output());
        $file = file_get_contents(base_path('public/contracts_pdf/') . $file_name);
        $base64 = base64_encode($file);

        $contract = Contract::create([
            'id' => $contract_id,
            'patient_plan_id' => $request->patient_plan_id,
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
}