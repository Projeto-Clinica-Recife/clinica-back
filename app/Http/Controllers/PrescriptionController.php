<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Helpers\Helper;
use PDF;

class PrescriptionController extends Controller
{
    public function generate(Request $request){
        $patient_name = $request->patient_name;
        $patient_cpf = Helper::mask($request->patient_cpf, '###.###.###-##');
        $doctor_name = $request->doctor_name;
        $crm = $request->doctor_crm;
        $crm_state = $request->crm_state;
        $prescription = $request->prescription;
        $date = $request->date_current;
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
        return $pdf->stream();
        // return $doctor_name;
    }
}