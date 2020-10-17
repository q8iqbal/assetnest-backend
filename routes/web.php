<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Models\Company;
use App\Models\User;
use Laravel\Lumen\Routing\Router;
use Illuminate\Http\Request;

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

$router->post('login', 'AuthController@login');
$router->post('register', 'AuthController@register');
$router->get('logout', 'AuthController@logout');


$router->group(['prefix' => 'user'], function () use ($router){
    $router->get('/', function (){
        $user = User::all();
        return response()->json([
            'user' => $user
        ]);
    });

    $router->get('/owner', function(){
        return 'get';
    });
    
    $router->get('/admin', function(){
        return 'get';
    });

    $router->get('/staff', function(){
        return 'get';
    });

    $router->get('/{id}', ['uses' => 'UserController@show']);

    $router->post('/', ['uses' => 'UserController@store']);

    $router->put('/{id}', ['uses' => 'UserController@update']);

    $router->delete('/{id}', ['uses' => 'UserController@destroy']);
});

$router->group(['prefix' => 'company'], function () use ($router){
    $router->get('/', ['uses' => 'CompanyController@index']);
    $router->get('/{id}', ['uses' => 'CompanyController@show']);
    $router->post('/', ['uses' => 'CompanyController@store']);
    $router->put('/{id}', ['uses' => 'CompanyController@update']);
    $router->delete('/{id}', ['uses' => 'CompanyController@destroy']);
});

$router->group(['prefix' => 'asset'], function () use ($router){
    $router->get('/', function(){
        return 'get';
    });

    $router->get('/{id}', function($id){
        return "get $id";
    });

    $router->post('/', function(){
        return 'post';
    });

    $router->put('/{id}', function($id){
        return "put $id";
    });

    $router->delete('/{id}', function($id){
        return "delete $id";
    });
});

$router->group(['prefix' => 'assethist'], function () use ($router){
    $router->get('/', function(){
        return 'get';
    });

    $router->get('/{id}', function($id){
        return "get $id";
    });

    $router->post('/', function(){
        return 'post';
    });

    $router->put('/{id}', function($id){
        return "put $id";
    });

    $router->delete('/{id}', function($id){
        return "delete $id";
    });
});