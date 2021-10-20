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

$router->get('/home', 'UsersController@get_users');


$router->group(['prefix' => 'api'], function () use ($router) {

    //Rota de Registro
    $router->post('/register', 'UsersController@register');
    // Rota de Login
    $router->post('/login', 'UsersController@login');
    
    $router->group(['middleware' => 'auth'], function () use ($router) {
        $router->get('/user', 'UsersController@get_user');
        $router->post('/logout', 'UsersController@logout');
    });
});
