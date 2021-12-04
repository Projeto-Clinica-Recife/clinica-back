<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;

class PatientController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public  function store(Request $request)
    {
        $query = Patient::create($request->all());
        if ($query) {
            $data = [
                'message' => 'Paciente cadastro com sucesso'
            ];
        } else {
            $data = [
                'message' => 'Erro ao cadastrar'
            ];
        }

        return response()->json($data, 200);
    }

    public function showById($id){
        $query = Patient::find($id);
        if (!$query) {
            $data = [
                'message' => 'Paciente não encontrado'
            ];
            return response()->json($data, 200);
        }else{
            return response()->json($query, 200);
        }
    }

    public  function show($id){
        $query = Patient::find($id);
        if(!$query){
        $queryTwo = Patient::where('nome','like','%'.$id.'%')
        ->orWhere('cpf','=', $id)
        ->get();
        if (count($queryTwo) > 0 ) {
            return response()->json($queryTwo, 200);
        }else if (count($queryTwo) == 0 ) {
            return response()->json(0, 200);
        }else{
             $data = [
                'message' => 'Erro ao consultar'
            ];
            return response()->json($data, 200);
        }
     }else{
        return response()->json($query, 200);
     }
        
    }
    public  function update(Request $request, $id){
        $query = Patient::find($id);
        if ($query) {
            $query->update($request->all());
            return response()->json($query, 200);
        } else {
            $data = [
                'message' => 'Erro ao editar'
            ];
            return response()->json($data, 200);
        }
        
    }

    public function destroy($id){
        $query = Patient::find($id)->delete();
        if ($query) {
            $data = [
                'message' => 'Paciente deletado com sucesso'
            ];
        } else {
            $data = [
                'message' => 'Erro ao deletar'
            ];
        }
        return response()->json($data, 200);
    }


    //
}
