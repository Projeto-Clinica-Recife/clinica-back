<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Receipt;
use Validator;

use Laravel\Lumen\Routing\Controller as BaseController;

class ReceiptController extends BaseController
{
    public function index(){
        return Receipt::all();
    }

    public function store(Request $request){

        $validate = Validator::make($request->all(),[
            'type_product' => 'required',
            'value' => 'required',
            'form_of_payment' => 'required',
            'payment_status' => 'required',
        ],[
            'required' => 'Verifique se todos os campos obrigatórios estão preenchidos!',
        ]);

        if($validate->fails()){
            return response(['message' => 'Verifique se todos os campos obrigatórios estão preenchidos!', 'error' =>  $validate->errors(), 'statusCode' => 422], 422);
        }

        $receipt = Receipt::create([
            'client_id' => $request->client_id,
            'doctor_id' => $request->doctor_id,
            'type_product' => $request->type_product,
            'value' => $request->value,
            'form_of_payment' => $request->form_of_payment,
            'observation' => $request->observation,
            'payment_status' => $request->payment_status,
            'value_remaining' => $request->value_remaining,
            'product_id' => $request->product_id,
        ]);

        return response()->json($receipt, 200);
    }
}
