<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Plan;
use Validator;

class PlanController extends Controller
{
    public function store(Request $request){
        $validate = Validator::make($request->all(),[
            'description' => 'required',
            'period' => 'required',
            'value' => 'required',
        ],[
            'required' => 'Você precisa informar todos os campos!',
        ]);

        if($validate->fails()){
            return response(['message' => 'Verifique se todos os campos estão preenchidos!', 'error' =>  $validate->errors(), 'statusCode' => 422], 422);
        }

        $plan = Plan::create([
            'description' => $request->description,
            'period' => $request->period,
            'value' => $request->value,
        ]);

        return response()->json([
            'message' => 'Plano cadastrado com sucesso!',
            'plan' => $plan,
        ]);
    }

    public function get_plans(){
        $plans = Plan::all();
        foreach($plans as $plan){
            $plan->value = number_format($plan->value, 2, ',', '.');
            switch($plan->status){
                case 'active':
                    $plan->status = 'Ativo';
                    break;
                case 'inactive': 
                    $plan->status = 'Cancelado';
                    break;
            };
        }
        return response()->json($plans);
    }

    public function canceled_plan($id){
        $plan = Plan::where('id', $id)->first();

        if(!$plan){
            return response()->json([
                'message' => 'Houve algum erro ao cancelar o Plano!',
            ]);
        }
        $plan->update([
            'status' => 'inactive',
        ]);
        
        return response()->json($plan);
    }
}