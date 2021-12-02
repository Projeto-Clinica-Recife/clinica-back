<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserInformation;
use GuzzleHttp\Client;
use Validator;

class UsersController extends Controller
{

    public function get_users(){
        $users = User::with('user_information')->get();
        return $users;
    }

    public function get_user_by_id($id){
        $user = User::where('id', $id)->get();
        return response()->json([
            $user
        ],200);
    }

    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'cpf' => 'required',
            'type_user' => 'required',
            'crm' => 'nullable',
            'telephone' => 'required',
        ], [
            'required' => 'O campo :attribute é obrigatório!',
            'email.email' => 'Digite um :attribute válido!',
            'cpf.required' => 'O campo CPF é obrigatório!',
            'type_user.required' => 'Informe um tipo de usuário!',
            'telephone.required' => 'O campo telefone é obrigatório!',
        ]
        );

        if($validator->fails()){
            return response(['message' => 'Validation errors', 'errors' =>  $validator->errors(), 'status' => false], 422);
        }

        $existingCpf = User::where('cpf', $request->cpf)->first();
        $existingEmail = User::where('email', $request->email)->first();
        if($existingCpf){
            return response()->json([
                'error' => 'Já existe um usuário cadastrado com esse CPF!',
            ], 400);
        }
        if($existingEmail){
            return response()->json([
                'error' => 'Já existe um usuário cadastrado com esse e-mail!',
            ], 400);
        }

        $password = Hash::make('12345678');
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'cpf' => $request->cpf,
            'type_user' => $request->type_user,
            'password' => $password,
        ]);

        $user_information = UserInformation::create([
            'telephone' => $request->telephone,
            'crm' => $request->crm,
            'user_id' => $user->id,
        ]);

        $token = $user->createToken('token')->accessToken;

        return response()->json([
            'user' => $user,
            'message' => 'Success!',
            'status' => true,
        ], 200);
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

        if(!Hash::check($credentials['password'], $user->password)){
            return response()->json([
                'error' => 'Senha incorreta',
            ], 404);
        }

        $token = $user->createToken('token')->accessToken;
        return response()->json([
            'token' => $token,
            'user' => $user,
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
        return response()->json([
            'user' => auth()->guard('api')->user(),
        ], 200);
    }
}