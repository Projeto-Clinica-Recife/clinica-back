<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\QueryPatient;
use App\Models\Patient;
use App\Models\AgenderProtocol;
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
      
      if($query){
         $query = AgenderProtocol::find($request->item_id);
        if ($query) {
            $query->update([
                'status' => 'finished',
            ]);
        } else {
            $data = [
                'message' => 'Erro ao finalizar agendamento'
            ];
            return response()->json($data, 200);
        }
      }

      return response()->json([
         'consult' => $query,
         'message' => 'Success!',
     ], 200);
   }

   public function getQueryPatient($id) {

        $query_patient = DB::table('patients')
        ->join('query_patients', 'patients.id', '=', 'query_patients.patient_id')
        ->join('agenders', 'patients.id', '=', 'agenders.patient_id')
        ->join('agender_protocols', 'agender_protocols.agender_id', '=', 'agenders.id')
        ->join('users', 'agenders.doctor_id', '=', 'users.id')
        ->select('agenders.hour', 'users.name', 'query_patients.plaint', 'query_patients.observation')
        ->where('query_patients.patient_id', $id)
        // ->where('agender_protocols.agender_id', 'agenders.id')
        ->get();

    return $query_patient;
   }
}