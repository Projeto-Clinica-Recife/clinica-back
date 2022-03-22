<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;

use Closure;

class CheckAdminUser
{
    public function handle($request, Closure $next){

        if ( !auth()->check() ){
            return response()->json([
                'message' => 'Unauthorized',
            ],401);
        }

        $user = auth()->user();

        if($user->type_user != 'admin'){
            return response()->json([
                'message' => 'Acesso negado!',
            ],401);
        }

        return $next($request);
    }
}