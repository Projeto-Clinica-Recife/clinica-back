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
    $router->put('/password/{id}', 'UsersController@redefine_password');
    $router->put('/first_access/{id}', 'UsersController@first_access');
    $router->delete('/{id}', 'UsersController@destroy');
});

$router->group(['prefix' => 'patient'], function () use ($router) {
    $router->post('/store', 'PatientController@store');
    $router->post('/cad-plan/{patientId}', 'PlanPatientController@store');
    $router->get('/{id}', 'PatientController@show');
    $router->get('/showby/{id}', 'PatientController@showById');
    $router->get('/plans/{patientId}/', 'PlanPatientController@get_plans_patient');
    $router->put('/{id}', 'PatientController@update');
    $router->delete('/{id}', 'PatientController@destroy');
    $router->get('/detail/{id}', 'QueryPatientController@getQueriesPatient');
    $router->get('/query/{queryId}', 'QueryPatientController@getQueryPatientById');
});

$router->group(['prefix' => 'doctor'], function () use ($router) {
    $router->get('/doctors', 'DoctorController@getDoctors');
    $router->get('/{id}', 'DoctorController@show');
    $router->get('/plans/{doctorId}/', 'DoctorController@get_linked_plans');
    $router->put('/{id}', 'DoctorController@update');
    $router->delete('/{id}', 'DoctorController@destroy');
    $router->get('/agender/{id}/{date}', 'CalendarController@getAgenderDoctor');
    $router->post('/query-patient', 'QueryPatientController@store');
});

$router->group(['prefix' => 'protocol'], function () use ($router) {
    $router->get('/protocols', 'ProtocolorController@getProtols');
    $router->get('/showProtocolAgender/{id}', 'ProtocolorController@showProtocolAgender');
    $router->post('/', 'ProtocolorController@store');
    $router->put('/delete/{id}', 'ProtocolorController@delete');
});

$router->group(['prefix' => 'agender'], function () use ($router) {
    $router->get('/{id}/{date}', 'CalendarController@getAgender');
    $router->get('/week', 'CalendarController@getAgenderByWeek');
    $router->post('/store', 'CalendarController@store');
    $router->put('/cancel-agender/{id}', 'CalendarController@cancelAgenderProtocol');
});

$router->group(['prefix' => 'contract'], function () use ($router) {
        $router->post('/{patient_id}', 'ContractController@generate');
        $router->get('/{contract_id}', 'ContractController@get_contractor_pdf');
});

$router->group(['prefix' => 'prescription'], function () use ($router){
    $router->post('/generate', 'PrescriptionController@generate');
    $router->get('/get-pdf/{prescription_id}', 'PrescriptionController@get_prescription_pdf');
});

$router->group(['prefix' => 'plan'], function () use ($router){
    $router->get('/', 'PlanController@get_plans');
    $router->get('/active', 'PlanController@get_plans_actives');
    $router->post('/store', 'PlanController@store');
    $router->put('/cancel/{id}', 'PlanController@canceled_plan');
    $router->put('/reactivate/{id}', 'PlanController@reactivatePlan');
});
