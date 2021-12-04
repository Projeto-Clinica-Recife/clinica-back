<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\QueryPatient;
use Validator;

class QueryPatientController extends Controller
{
   public function store(Request $request){
      
      $validator = Validator::make($request->all(), [
         'doctor_id' => 'required',
         'patient_id' => 'required',
         'protocols' => 'required',
         'plaint' => 'required',
         'observation' => 'required',
     ], [
         'doctor_id.required' => 'O campo medico é obrigatório!',
         'patient_id.required' => 'O campo paciente é obrigatório!',
         // 'protocols_id.required' => 'Por favor informe o protocolo',
         'protocols.required' => 'Por favor informe os protocolos',
         'plaint.required' => 'Por favor informe as queixas',
         'observation.required' => 'Por favor informe as observações',
     ]);

     if ($validator->fails()) {
         return response(['message' => 'Erro na validação do formulário!', 'errors' =>  $validator->errors(), 'status' => false], 422);
     }

      $query = QueryPatient::create([
         'doctor_id' => $request->doctor_id,
         'patient_id' => $request->patient_id,
         'plaint' => $request->plaint,
         'observation' => $request->observation,
         'protocols' =>$request->protocols
      ]);

      return response()->json([
         'consult' => $query,
         'message' => 'Success!',
     ], 200);
   }
}