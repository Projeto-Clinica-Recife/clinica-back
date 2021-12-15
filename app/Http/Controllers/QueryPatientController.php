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
         'agender_protocol_id' => $request->item_id,
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

   public function getQueriesPatient($id) {

        $queries_patient = DB::table('patients')
        ->join('query_patients', 'patients.id', '=', 'query_patients.patient_id')
        // ->join('patients_plans', 'patients.id', '=', 'patients_plans.patient_id')
        ->join('agender_protocols', 'query_patients.agender_protocol_id', '=', 'agender_protocols.id')
        ->join('agenders', 'agender_protocols.agender_id', '=', 'agenders.id')
        ->join('users', 'agenders.doctor_id', '=', 'users.id')
        ->join('user_information', 'users.id', '=', 'user_information.user_id')
        ->select('agenders.date', 'agenders.hour',
        'users.name as doctor_name', 'user_information.crm as doctor_crm', 'user_information.crm_state as doctor_crm_state',
        'query_patients.id as query_id','query_patients.plaint', 'query_patients.observation', 'query_patients.protocols')
        ->where('patients.id', $id)
        ->get();

        return $queries_patient;
   }

   public function getQueryPatientById($queryId){
        $query = DB::table('query_patients')
        ->join('agender_protocols', 'query_patients.agender_protocol_id', '=', 'agender_protocols.id')
        ->join('agenders', 'agender_protocols.agender_id', '=', 'agenders.id')
        ->where('query_patients.id', $queryId)
        ->select('query_patients.*')
        ->addSelect('agender_protocols.*')
        ->addSelect('agenders.*')
        ->get();
        $agenda = null;
        foreach($query as $q){
            $agenda = $q->plaint;
        }
        return $query;
    }
}