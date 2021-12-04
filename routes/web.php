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
    return \Illuminate\Support\Str::random(43);
});


$router->group(['prefix' => 'api'], function () use ($router) {
    //Rota de Registro
    $router->post('/register', 'UsersController@register');
    // Rota de Login
    $router->post('/login', 'AuthController@login');
    
    $router->group(['middleware' => 'auth'], function () use ($router) {
        $router->get('/user', 'AuthController@get_user');
        $router->post('/logout', 'AuthController@logout');
    });
});
$router->group(['prefix' => 'user'], function () use ($router) {
    $router->get('/', 'UsersController@get_users');
    $router->get('/{id}', 'UsersController@get_user_by_id');
    $router->put('/update/{id}', 'UsersController@update');
    $router->delete('/{id}', 'UsersController@destroy');
});
$router->group(['prefix' => 'patient'], function () use ($router) {
    $router->post('/store', 'PatientController@store');
    $router->get('/{id}', 'PatientController@show');
    $router->put('/{id}', 'PatientController@update');
    $router->delete('/{id}', 'PatientController@destroy');
});

$router->group(['prefix' => 'doctor'], function () use ($router) {
    $router->get('/doctors', 'DoctorController@getDoctors');
    $router->post('/store', 'DoctorController@show');
    $router->get('/agender/{id}/{date}', 'CalendarController@getAgenderDoctor');
});

$router->group(['prefix' => 'protocol'], function () use ($router) {
    $router->get('/protocols', 'ProtocolorController@getProtols');
    $router->get('/showProtocolAgender/{id}', 'ProtocolorController@showProtocolAgender');
});

$router->group(['prefix' => 'agender'], function () use ($router) {
    $router->get('/{id}/{date}', 'CalendarController@getAgender');
    $router->post('/store', 'CalendarController@store');
    $router->put('/cancel-agender/{id}', 'CalendarController@cancelAgenderProtocol');
});
