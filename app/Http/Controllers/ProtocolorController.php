<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Protocol;

class ProtocolorController extends Controller
{
    public function getProtols(){
        $protocols = Protocol::all();
        
        return response()->json(
            $protocols,
        200);
    }

    public function store(Request $request){
        $protocol = Protocol::create([
            'descricao' => $request->description,
            'value' => $request->value,
        ]);

        if(!$protocol){
            return response()->json([
                'error' => 'Erro ao cadastrar o protocolo!',
            ]);
        };

        return response()->json([
            'message' => 'Protocolo cadastrado com sucesso!',
            'protocolo' => $protocol,
        ],200);
    }

    public function delete($id, Request $request){
        $protocol = Protocol::find($id);

        $deletar = $protocol->delete();

        if (!$deletar) {
            return response()->json([
                'error' => 'Hou algum ao excluir o protocolo!',
            ], 400);
        }

        return response()->json([
            'message' => 'Protocolo excluir com sucesso!',
        ], 200);
    }

}