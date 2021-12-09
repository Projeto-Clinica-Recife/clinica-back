<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request  $request){
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        $user = User::where('email', $credentials['email'])->with('user_information')->first();
        if(!$user){
            return response()->json(['error' => 'Usuário não encontrado'], 404);
        }

        if(!Hash::check($credentials['password'], $user->password)){
            return response()->json([
                'error' => 'Senha incorreta',
            ], 404);
        }

        $token = $user->createToken('token')->accessToken;
        return response()->json([
            'token' => $token,
            'user' => $user,
            'statusCode' => 200,
        ], 200);
    }

    public function logout(Request $request){
        try{
            auth()->user()->tokens()->each(function ($token) {
                $token->delete();
            });
            return response()->json([
                'message' => 'logout success!',
            ]);
        } catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function get_user(){
        $user = auth()->guard('api')->user();
        $user = User::where('id', $user->id)->with('user_information')->first();
        return response()->json([
            'user' => $user,
        ], 200);
    }
}