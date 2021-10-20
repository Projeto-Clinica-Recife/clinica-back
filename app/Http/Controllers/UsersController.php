<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use GuzzleHttp\Client;
use Validator;

class UsersController extends Controller
{

    public function get_users(){
        $users = User::all();
        return $users;
    }

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

        $token = $user->createToken('token')->accessToken;
        // $data['name'] = $user->name;

        return response([
            'data' => $token,
            'message' => 'Success!',
            'status' => true,
        ]);
    }

    public function login(Request  $request){
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        $user = User::where('email', $credentials['email'])->first();
        if(!$user){
            return response()->json(['error' => 'Usuário não encontrado'], 404);
        }
        // if(!Auth::attempt($credentials)){
        //     $error = 'Não autorizado';
        //     $result = [
        //         'error' => $error,
        //     ];
        // }
        if(!Hash::check($credentials['password'], $user->password)){
            return response()->json(false);
        }

        $token = $user->createToken('token')->accessToken;
        return response()->json(
            [
            'token' => $token
        ], 200);
        // $api_url = env('APP_URL');
        // $client_id = env('PASSPORT_CLIENT_ID');
        // $client_secret = env('PASSPORT_CLIENT_SECRET');

        // $guzzle  = new Client();

        // $request = $guzzle->get(uri: 'https://viacep.com.br/ws/48904755/json/');
        // return $request->getBody();
        // try {
        //     return $guzzle ->request('POST', 'http://localhost:8000/v1/oauth/token',[
        //         'form_params' => [
        //             "grant_type" => "password",
        //             "client_id" => $client_id,
        //             "client_secret" => $client_secret,
        //             "username" => $request->email,
        //             "password" => $request->password,
        //             "scope" => ""
        //         ]
        //     ]);
        // }catch(BadRequestException $e){
        //     return response()->json([
        //         'status' => 'error', 'message' => $e->getMessage(),
        //     ]);
        // }
    }

    public function get_user(){
        return response()->json([
            'user' => auth()->guard('api')->user(),
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

}