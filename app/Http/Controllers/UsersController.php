<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Validator;

class UsersController extends Controller
{

    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($validator->fails()){
            return response(['message' => 'Validation errors', 'errors' =>  $validator->errors(), 'status' => false], 422);
        }

        $input = $request->all();
        $input['password'] = Hash::make($input['password'],);
        $user = User::create($input);

        $data['token'] = $user->createToken('token')->accessToken;
        $data['name'] = $user->name;

        return response([
            'data' => $data,
            'message' => 'Success!',
            'status' => true,
        ]);
    }

}