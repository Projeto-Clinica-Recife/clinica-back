<?php
namespace App\http\Middleware;

use Closure;



class CorsMiddleware {

    // public function handle($request, Closure $next)
    // {
    //     return $next($request)
    //     //Acrescente as 3 linhas abaixo
    //     ->header('Access-Control-Allow-Origin', "*")
    //     ->header('Access-Control-Allow-Methods', "PUT, POST, DELETE, GET, OPTIONS")
    //     ->header('Access-Control-Allow-Headers', "Accept, Authorization, Content-Type");
    // }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next)
    {
        $headers = [
            'Access-Control-Allow-Origin'      => '*',
            'Access-Control-Allow-Methods'     => 'POST, GET, OPTIONS, PUT, DELETE',
            'Access-Control-Allow-Credentials' => 'true',
            'Access-Control-Max-Age'           => '86400',
            'Access-Control-Allow-Headers'     => 'Content-Type, Authorization, X-Requested-With',
        ];

        if ($request->isMethod('OPTIONS'))
        {
            return response()->json('{"method":"OPTIONS"}', 200, $headers);
        }

        $response = $next($request);
    
        foreach($headers as $key => $value)
        {
            $response->header($key, $value);
        }

        return $response;
    }
}