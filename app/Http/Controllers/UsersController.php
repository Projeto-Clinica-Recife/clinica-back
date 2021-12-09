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
        $user = User::where('id', $id)
        ->with('user_information')
        ->get();
        return response()->json(
            $user
        ,200);
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
            return response(['message' => 'Validation errors', 'error' =>  $validator->errors(), 'statusCode' => 422], 422);
        }

        $existingCpf = User::where('cpf', $request->cpf)->first();
        $existingEmail = User::where('email', $request->email)->first();
        if($existingCpf){
            return response()->json([
                'error' => 'Já existe um usuário cadastrado com esse CPF!',
                'statusCode' => 400,
            ], 400);
        }
        if($existingEmail){
            return response()->json([
                'error' => 'Já existe um usuário cadastrado com esse e-mail!',
                'statusCode' => 400,
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
            'user' => [$user],
            'information_user' => $user_information,
            'message' => 'Success!',
            'statusCode' => 200,
        ], 200);
    }

    public function update($id, Request $request){
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->cpf = $request->cpf;
        $user->password = $request->password;
        $user->save();

        $user_information = UserInformation::where('user_id', $user->id)->first();
        $user_information->telephone = $request->telephone;
        $user_information->crm = $request->crm;
        $user_information->crm_state = $request->crm_state;
        $user_information->save();

        if ($user && $user_information) {
            return response()->json([
                'message' => 'Editado com sucesso!',
                'statusCode' => 200,
            ], 200);
        } else {
            $message = [
                'message' => 'Houve erro ao editar',
                'StatusCode' => 400
            ];
        }

        return response()->json(
            $message, 200
        );
    }

    public function  redefine_password($id, Request $request){
        $user = User::where('id', $id)->first();
        $user->password = Hash::make($request->password);
        $save_password = $user->save();

        if(!$save_password){
            return response()->json([
                "message" => "Erro ao alterar a senha!",
                "statusCode" => 400,
            ], 400);
        }

        return response()->json([
             "message" => "Senha alterada com sucesso!",
             'user' => $user,
             "statusCode" => 200,
        ], 200);
    }

    public function destroy($id){
        $user = User::find($id);
        return response()->json(
            $user, 200
        );
    }

    public function first_access($id){
        $user = User::find($id);
        if($user->first_access){
            $user->first_access = false;
            $save = $user->save();
            if(!$save){
                return false;
            }
        }
        return true;
    }
}