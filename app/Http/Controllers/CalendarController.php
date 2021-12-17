<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Agender;
use App\Models\AgenderProtocol;
use App\Models\Protocol;
use Protocols;
use Validator;

class CalendarController extends Controller
{

    public function getAgenderByWeek(Request $request){
        $date = strtotime($request->date);
        $date = date('Y-m-d', $date);

        $agender = Agender::with('doctor')
        ->orderBy('date')
        ->with('patient')
        ->get();

        //Pega o dia da semana em numeral
        $day = date('w', strtotime($date));
        //Pega o primeiro dia da semana
        $week_start = date('Y-m-d', strtotime($date.'-'.$day.'days'));
        //Pega o último dia da semana
        $week_end = date('Y-m-d', strtotime($date.'+'.(6-$day).'days'));

        $agender_week = [];

        foreach ($agender as $ag){
            if($ag->date >= $week_start && $ag->date <= $week_end) {
                array_push($agender_week, $ag);
            }
        }

        return response()->json(
            $agender_week,
        );
    }

    public function getAgender($id, $date)
    {
        $agender = DB::table('agender_protocols')
            ->join('agenders', 'agender_protocols.agender_id', '=', 'agenders.id')
            ->join('protocols', 'agender_protocols.protocol_id', '=', 'protocols.id')
            ->join('users', 'agenders.doctor_id', '=', 'users.id')
            ->select('agenders.hour', 'protocols.descricao as protocol', 'users.name as doctor', 'status', 'agender_protocols.id')
            ->where('patient_id', $id)
            ->where('date', $date)
            ->orderBy('status', 'asc')
            ->orderBy('agenders.hour', 'asc')
            ->get();

        return response()->json($agender);
    }

    public function getAgenderDoctor($id, $date)
    {
        $agender = DB::table('agender_protocols')
            ->join('agenders', 'agender_protocols.agender_id', '=', 'agenders.id')
            ->join('patients', 'agenders.patient_id', '=', 'patients.id')
            ->select(
            'agenders.hour',
            'agender_id',
            'patients.id as patient_id',
            'patients.nome as patient',
            'status',
            'agender_protocols.id as item_id'
            )
            ->where('doctor_id', $id)
            ->where('date', $date)
            ->where('status', '<>', 'canceled')
            ->orderBy('status', 'asc')
            ->orderBy('agenders.hour', 'asc')
            ->get();

        return response()->json($agender);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'date' => 'required',
            'hour' => 'required',
            // 'protocols_id' => 'required',
            'doctor_id' => 'required',
            'patient_id' => 'required',
        ], [
            'date.required' => 'O campo data é obrigatório!',
            'hour.required' => 'O campo horário é obrigatório!',
            // 'protocols_id.required' => 'Por favor informe o protocolo',
            'doctor_id.required' => 'Por favor informe o médico',
            'patient_id.required' => 'Por favor informe o paciente',
        ]);

        if ($validator->fails()) {
            return response(['message' => 'Erro na validação do formulário!', 'errors' =>  $validator->errors(), 'status' => false], 422);
        }
        $rules = DB::table('agenders')
            ->join('agender_protocols', 'agenders.id', '=', 'agender_protocols.agender_id')
            ->where('date', $request->date)
            ->where('hour', $request->hour)
            ->where('agender_protocols.status', '<>', 'canceled')
            ->get();
        // $rules = Agender::where('date', $request->date)
        // ->where('hour', $request->hour)->get();


        // $protocols = implode(',', $request->protocols_id);
        if (count($rules) > 0) {
            return response()->json([
                'message' => 'Já existe um agendamento nesta data e horário',
            ]);
        }

        $agender = Agender::create([
            'date' => $request->date,
            'hour' => $request->hour,
            'hourEnd' => $request->hourEnd,
            // 'protocols_id' => $protocols,
            'doctor_id' => $request->doctor_id,
            'patient_id' => $request->patient_id,
        ]);


        foreach ($request->protocols_id as  $protocol) {
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

    public function cancelAgenderProtocol($id)
    {
        $query = AgenderProtocol::find($id);
        if ($query) {
            $query->update([
                'status' => 'canceled',
            ]);
            return response()->json($query, 200);
        } else {
            $data = [
                'message' => 'Erro ao cancelar'
            ];
            return response()->json($data, 200);
        }
    }


}
