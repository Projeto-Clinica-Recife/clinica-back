<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

//Gera Chave aleatória para o env

$router->get('/key', function() {
    return \Illuminate\Support\Str::random(32);
});

$router->get('/home', 'Controller@teste');


$router->group(['prefix' => 'api'], function () use ($router) {
    //Rota de Registro
    $router->post('/register', 'UsersController@register');
});

$router->group(['prefix' => 'paciente'], function () use ($router) {
    $router->get('/cadastro', 'PatientController@store');
    $router->get('/{id}', 'PatientController@show');
    $router->put('/{id}', 'PatientController@update');
    $router->delete('/{id}', 'PatientController@destroy');
});
