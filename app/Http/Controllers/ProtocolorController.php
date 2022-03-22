<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Protocol;
use App\Models\User;

class ProtocolorController extends Controller
{
    public function getProtols(){
        $protocols = DB::table('protocols')
            ->orderBy('status', 'asc')
            ->get();;
        
        foreach($protocols as $protocol){
            $protocol->value = number_format($protocol->value, 2, ',', '.');
            switch($protocol->status){
                case 'active':
                    $protocol->status = 'Ativo';
                    break;
                case 'inactive': 
                    $protocol->status = 'Inativo';
                    break;
            };
        }

        return response()->json(
            $protocols,
        200);
    }

    public function getActiveProtocols(){
        $protocols = DB::table('protocols')
        ->where('status', 'active')
        ->get();;

        return response()->json(
            $protocols,
        200);
    }

    public function getProtolById($id){
        $protocol = Protocol::find($id);

        if(is_null($protocol)){
            return response()->json(['error' => 'Protocolo não encontrado!'],404);
        }

        return response()->json($protocol);
    }

    public function store(Request $request){
        $protocol = Protocol::create([
            'descricao' => $request->description,
            'value' => $request->value,
            'doctor_id' => $request->doctor_id,
        ]);

        if(!$protocol){
            return response()->json([
                'error' => 'Erro ao cadastrar o protocolo!',
            ],500);
        };

        return response()->json([
            'message' => 'Protocolo cadastrado com sucesso!',
            'protocolo' => $protocol,
        ],200);
    }

    public function update($id, Request $request){
        $protocol = Protocol::find($id);

        if(is_null($protocol)){
            return response()->json(['error' => 'Protocolo não existe!'],404);
        }

        $result = $protocol->update([
            'descricao' => $request->descricao,
            'value' => $request->value,
        ]);

        if(!$result){
            return response()->json([
                'error' => 'Erro ao editar o protocolo!',
            ],500);
        };

        return response()->json([
            'message' => 'Protocolo editado com sucesso!',
            'protocol' => $protocol,
        ]);
    }

    public function disableOrActive($id){
        $protocol = Protocol::find($id);

        if(is_null($protocol)){
            return response()->json(['message' => 'Protocolo não encontrado!'],404);
        }

        $message = '';

        if($protocol->status == 'active'){
            $protocol->update([
                'status' => 'inactive',
            ]);

            $message = 'Protocolo desativado com sucesso!';
        } else {
            $protocol->update([
                'status' => 'active',
            ]);

            $message = 'Protocolo reativado com sucesso!';
        }

        return response()->json([
            'message' => $message,
        ],200);
    }

    public function delete($id, Request $request){
        $protocol = Protocol::find($id)->with('agender_protocol');

        $protocol_agenders = DB::table('protocols')
        ->join('agender_protocols', 'protocols.id', '=', 'agender_protocols.protocol_id')
        ->where('protocols.id', $id)
        ->exists();

        if($protocol_agenders) {
            return response()->json([
                'message' => 'Existem uma ou mais agenda com esse protocolo!',
            ],500);
        };

        return response()->json($protocol_agenders);

        $deletar = $protocol->delete();

        if (!$deletar) {
            return response()->json([
                'error' => 'Hou algum ao excluir o protocolo!',
            ], 500);
        }

        return response()->json([
            'message' => 'Protocolo excluir com sucesso!',
        ], 200);
    }

}