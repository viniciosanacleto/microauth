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

/** USER ROUTES */
$router->post('user', 'UserController@create');
//$router->put('user/{id}', 'UserController@update');
//$router->delete('user/{id}', 'UserController@delete');
//$router->get('user', 'UserController@getAll');
//$router->get('user/{id}', 'UserController@getById');
//$router->get('user/all-random-code', 'UserController@getAllRandomCode');
$router->post('verify', 'AuthController@verify');
$router->post('login', 'AuthController@login');