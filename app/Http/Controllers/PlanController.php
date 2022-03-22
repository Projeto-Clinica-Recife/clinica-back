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
        $plans = DB::table('plans')
        ->orderBy('status', 'asc')
        ->get();
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

    public function get_plan_by_id($id){
        $plan = Plan::find($id);

        if(is_null($plan)){
            return response()->json(['error' => 'Plano não encontrado!'],404);
        }

        return response()->json($plan);
    }

    public function  get_plans_actives(){
        $plans = DB::table('plans')
        ->where('status', 'active')
        ->orderBy('status', 'asc')
        ->get();
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

    public function update($id, Request $request){
        $plan = Plan::find($id);

        if(is_null($plan)){
            return response()->json(['error' => 'Plano não encontrado!'],404);
        }

        try{
            $plan->update([
                'description' => $request->description,
                'period' => $request->period,
                'value' => $request->value,
            ]);

            return response()->json($plan);
        }catch(Exception $e){
            return response()->json(['error' => 'Houve algum erro ao salvar!'],500);
        }

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
        
        return response()->json([
            'message' => 'Plano cancelado com sucesso!',
            'plan' => $plan,
        ], 200);
    }

    public function reactivatePlan($id){
        $plan = Plan::where('id', $id)->first();

        if(!$plan){
            return response()->json([
                'message' => 'Houve algum erro ao cancelar o Plano!',
            ]);
        }
        if ($plan->status == 'active') {
            return response()->json([
                'message' => 'Esse plano já está inativo!',
            ]);
        }
        $plan->update([
            'status' => 'active',
        ]);
        
        return response()->json([
            'message' => 'Plano reativado com sucesso!',
            'plan' => $plan,
        ],200);
    }
}