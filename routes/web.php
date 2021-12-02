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
    $router->get('/get_users', 'UsersController@get_users');
    $router->get('/get_user_by_id/{id}', 'UsersController@get_user_by_id');
    //Rota de Registro
    $router->post('/register', 'UsersController@register');
    // Rota de Login
    $router->post('/login', 'UsersController@login');
    
    $router->group(['middleware' => 'auth'], function () use ($router) {
        $router->get('/user', 'UsersController@get_user');
        $router->post('/logout', 'UsersController@logout');
    });
});

$router->group(['prefix' => 'patient'], function () use ($router) {
    $router->post('/store', 'PatientController@store');
    $router->get('/{id}', 'PatientController@show');
    $router->put('/{id}', 'PatientController@update');
    $router->delete('/{id}', 'PatientController@destroy');
});

$router->group(['prefix' => 'doctor'], function () use ($router) {
    $router->get('/doctors', 'DoctorController@getDoctors');
    $router->post('/store', 'PatientController@store');
    $router->get('/{id}', 'PatientController@show');
    $router->put('/{id}', 'PatientController@update');
    $router->delete('/{id}', 'PatientController@destroy');
});

$router->group(['prefix' => 'protocol'], function () use ($router) {
    $router->get('/protocols', 'ProtocolorController@getProtols');
});
