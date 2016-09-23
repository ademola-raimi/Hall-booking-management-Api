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

$app->group(['prefix' => 'api/v1', 'namespace' => 'App\Http\Controllers/Auth'], function () use ($app) {
    $app->get('/', function () use ($app) {
            return json_encode(["message" => "Welcome to Hall Bookings and management platform"]);
    });
    
    $app->post('register', [
            'uses' => 'AuthController@postRegister',
    ]);

    $app->post('login', [
            'uses' => 'AuthController@authenticate',
    ]);
});

$app->group(['prefix' => 'api/v1', 'namespace' => 'App\Http\Controllers', 'middleware' => 'regular.user'], function () use ($app) {
	$app->get('halls', [
		'uses' => 'HallController@getHalls',
	]);

	$app->get('hall/{id}', [
		'uses' => 'HallController@getHallById',
	]);
});

$app->group(['prefix' => 'api/v1', 'namespace' => 'App\Http\Controllers', 'middleware' => 'admin.user'], function () use ($app) {
	$app->post('hall', [
		'uses' => 'HallController@createHall',
	]);

	$app->put('hall', [
		'uses' => 'HallController@updateHallByPut',
	]);

	$app->patch('hall', [
		'uses' => 'HallController@updateHallByPatch',
	]);
});

$app->group(['prefix' => 'api/v1', 'namespace' => 'App\Http\Controllers', 'middleware' => 'super-admin.user'], function () use ($app) {

});