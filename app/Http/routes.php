<?php

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


$app->group(['prefix' => 'api/v1', 'namespace' => 'App\Http\Controllers'], function () use ($app) {
    $app->get('/', function () use ($app) {
            return json_encode(["message" => "Welcome to Hall Bookings and management platform"]);
    });
    
    $app->post('register', [
            'uses' => 'AuthController@postRegister',
    ]);
});

$app->group(['prefix' => 'api/v1', 'namespace' => 'App\Http\Controllers', 'middleware' => 'superAdmin.user'], function () use ($app) {
    $app->get('/test/1', function () use ($app) {
            return json_encode(["message" => "Welcome to Hall Bookings and management platform"]);
    });
});

$app->group(['prefix' => 'api/v1', 'namespace' => 'App\Http\Controllers', 'middleware' => 'admin.user'], function () use ($app) {
    $app->get('/test/2', function () use ($app) {
            return json_encode(["message" => "Welcome to Hall Bookings and management platform"]);
    });
});

$app->group(['prefix' => 'api/v1', 'namespace' => 'App\Http\Controllers', 'middleware' => 'regular.user'], function () use ($app) {
    $app->get('/test/3', function () use ($app) {
            return json_encode(["message" => "Welcome to Hall Bookings and management platform"]);
    });
});
