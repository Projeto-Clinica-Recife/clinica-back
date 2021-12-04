<?php

namespace App\Http\Controllers;

use PDF;

class PrescriptionController extends Controller
{
    public function generate(){
        $pdf = PDF::setPaper('a4');
        $pdf = $pdf->loadView('prescription.prescription');
        return $pdf->stream();
    }
}