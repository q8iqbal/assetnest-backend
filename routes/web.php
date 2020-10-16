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
$router->post('tes', 'Controller@uploadImage');


$router->group(['prefix' => 'user'], function () use ($router){
    // $router->get('/', ['middleware' => 'auth.role:1', function(){
    //     return 'oppai';
    // }]);

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

$router->group(['prefix' => 'company'], function () use ($router){
    $router->get('/', function(){
        $company = Company::all();
        return response()->json([
            'company' => $company
        ]);
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

$router->group(['prefix' => 'asset_attachment'], function () use ($router){
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