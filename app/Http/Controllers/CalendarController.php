<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Agender;
use App\Models\AgenderProtocol;
use Validator;

class CalendarController extends Controller
{

    public function getAgender($id, $date){
        $agender = Agender::where('patient_id', $id)
        ->where('date', $date)
        ->with('doctor:id,name')
        ->get();
        return response()->json($agender);
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(),[
            'date' => 'required',
            'hour' => 'required',
            // 'protocols_id' => 'required',
            'doctor_id' => 'required',
            'patient_id' => 'required',
        ],[
            'date.required' => 'O campo data é obrigatório!',
            'hour.required' => 'O campo horário é obrigatório!',
            // 'protocols_id.required' => 'Por favor informe o protocolo',
            'doctor_id.required' => 'Por favor informe o médico',
            'patient_id.required' => 'Por favor informe o paciente',
        ]);

        if($validator->fails()){
            return response(['message' => 'Erro na validação do formulário!', 'errors' =>  $validator->errors(), 'status' => false], 422);
        }

        $rules = Agender::where('date', $request->date)
        ->where('hour', $request->hour)->get();

        // $protocols = implode(',', $request->protocols_id);
        if(count($rules) > 0){
            return response()->json([
                'message' => 'Já existe um agendamento nesta data e horário',
            ]);
        }

        $agender = Agender::create([
            'date' => $request->date,
            'hour' => $request->hour,
            // 'protocols_id' => $protocols,
            'doctor_id' => $request->doctor_id,
            'patient_id' => $request->patient_id,
        ]);


        foreach($request->protocols_id as  $protocol){
            $agender_protocol = AgenderProtocol::create([
                'agender_id' => $agender->id,
                'protocol_id' => $protocol,
            ]);
        };

        return response()->json([
            'agender' => $agender,
            'message' => 'Success!',
        ], 200);
    }
}