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
    $router->get('/copy/{id}', 'UsersController@get_data_to_copy');
    $router->put('/update/{id}', 'UsersController@update');
    $router->put('/password/{id}', 'UsersController@redefine_password');
    $router->put('/first_access/{id}', 'UsersController@first_access');
    $router->delete('/{id}', 'UsersController@destroy');
});

$router->group(['prefix' => 'patient'], function () use ($router) {
    $router->get('/all',  'PatientController@all');
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
    $router->get('/showby/{id}', 'DoctorController@showById');
    $router->get('/plans/{doctorId}/', 'DoctorController@get_linked_plans');
    $router->put('/{id}', 'DoctorController@update');
    $router->post('/upload-image/{id}', 'DoctorController@upload_logo_doctor');
    $router->delete('/{id}', 'DoctorController@destroy');
    $router->get('/agender/{id}/{date}', 'CalendarController@getAgenderDoctor');
    $router->post('/query-patient', 'QueryPatientController@store');
});

$router->group(['prefix' => 'protocol', 'middleware' => 'auth'], function () use ($router) {
    $router->get('/', 'ProtocolorController@getProtols');
    $router->get('/active', 'ProtocolorController@getActiveProtocols');
    $router->get('/{id}', 'ProtocolorController@getProtolById');
    $router->get('/showProtocolAgender/{id}', 'ProtocolorController@showProtocolAgender');
    $router->post('/', 'ProtocolorController@store');
    $router->put('/{id}', 'ProtocolorController@update');
    $router->put('/disable/{id}', 'ProtocolorController@disableOrActive');
    $router->delete('/{id}', 'ProtocolorController@delete');
});

$router->group(['prefix' => 'agender'], function () use ($router) {
    $router->get('/{id}/{date}', 'CalendarController@getAgender');
    $router->post('/week', 'CalendarController@getAgenderByWeek');
    $router->post('/store', 'CalendarController@store');
    $router->put('/cancel-agender/{id}', 'CalendarController@cancelAgenderProtocol');
});

$router->group(['prefix' => 'contract'], function () use ($router) {
        $router->post('/{patient_id}', 'ContractController@generate');
        $router->get('/{contract_id}', 'ContractController@get_contractor_pdf');
        $router->put('edit/{contractId}', 'ContractController@edit_contract');
});

$router->group(['prefix' => 'prescription', 'middleware' => 'auth'], function () use ($router){
    $router->post('/generate', 'PrescriptionController@generate');
    $router->get('/get-pdf/{prescription_id}', 'PrescriptionController@get_prescription_pdf');
});

$router->group(['prefix' => 'plan', 'middleware' => 'auth'], function () use ($router){
    $router->get('/', 'PlanController@get_plans');
    $router->get('/get-plan/{id}', 'PlanController@get_plan_by_id');
    $router->get('/active', 'PlanController@get_plans_actives');
    $router->get('/search-patient/{item}', 'PlanPatientController@search_plan_patient');
    $router->get('/search-doctor/{item}', 'PlanPatientController@search_plan_doctor');
    $router->post('/store', 'PlanController@store');
    $router->put('edit/{id}', 'PlanController@update');
    $router->put('/cancel/{id}', 'PlanController@canceled_plan');
    $router->put('/reactivate/{id}', 'PlanController@reactivatePlan');
});

$router->group([ 'prefix' => 'receipt'], function () use ($router){
    $router->post('/', 'ReceiptController@store');
    $router->get('/', 'ReceiptController@index');
});