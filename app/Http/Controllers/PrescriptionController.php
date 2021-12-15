<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Agender;
use App\Models\Prescription;
use App\Models\Patient;
use App\Helpers\Helper;
use \Illuminate\Support\Str;
use PDF;

class PrescriptionController extends Controller
{
    public function generate(Request $request){
        $patient = Patient::find($request->patient_id);
        $agender_id = $request->agender_id;
        $patient_name = $patient->nome;
        $patient_cpf = Helper::mask($patient->cpf, '###.###.###-##');
        $doctor_name = $request->doctor_name;
        $crm = $request->doctor_crm;
        $crm_state = $request->crm_state;
        $prescription = $request->prescription;

        $date = date('d/m/Y');

        $prescription_id = Str::uuid();

        $pdf = PDF::setPaper('a4');
        $pdf = $pdf->loadView('prescription.prescription', compact(
            'patient_name',
            'doctor_name',
            'crm',
            'crm_state',
            'patient_cpf',
            'prescription',
            'date',
        ));
        $file_name = $prescription_id . '_' . $patient_name . '_' . $request->patient_cpf . '.pdf';
        file_put_contents('prescriptions_pdf/' . $file_name, $pdf->output());
        $file_path = base_path('public/prescriptions_pdf/' . $file_name);
        $file = file_get_contents(base_path('public/prescriptions_pdf/') . $file_name);
        $base64 = base64_encode($file);

        $prescription_save = Prescription::create([
            'id' => $prescription_id,
            'agender_id' => $agender_id,
            'base64' => $base64,
            'file_name' => $file_name,
        ]);

        return response()->json(
            $base64,
        );
    }

    public function get_prescription_pdf($prescription_id){

        $prescription = Prescription::where('id', $prescription_id)->first();
        $file_path = base_path('public/prescriptions_pdf/' . $file_name);
        $file = file_get_contents(base_path('public/prescriptions_pdf/') . $file_name);
        $base64 = base64_encode($file);
        return response()->json(
            $base64,
        );
    }
}