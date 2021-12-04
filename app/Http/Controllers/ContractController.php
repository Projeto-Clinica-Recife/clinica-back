<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Patient;
use App\Models\User;
use App\Helpers\Helper;
use PDF;
use Closure;

class ContractController extends Controller
{
    public function generate($id){
        $patient = Patient::where('id', $id)
        ->first();
        $patient->cpf = Helper::mask($patient->cpf, '###.###.###.-##');
        $patient->cep = Helper::mask($patient->cep, '#####-###');
        $pdf = PDF::setPaper('a4');
        // $pdf = $pdf->loadView('contract.contract-layout', compact('patient'));
        $pdf = $pdf->loadView('contract.contract-layout', compact('patient'));
        $file_name = $patient->nome . '_' . $patient->cpf . '_' . date('d-m-Y') . '.pdf';
        // file_put_contents('contracts_pdf/'.$file_name, $pdf->output());
        $file = file_get_contents(base_path('public/contracts_pdf/') . 'Herbet_123.456.585.-91_04-12-2021.pdf');
        $urlFile = base_path('public/contracts_pdf/') . 'Herbet_123.456.585.-91_04-12-2021.pdf';
        return $pdf->stream();
    }

    public function contractor_download($name){
        
    }
}