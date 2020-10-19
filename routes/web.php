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
$router->post('tes', function(Request $request){
    return response($request->all());
});


$router->group(['prefix' => 'users'], function () use ($router){
    $router->get('/', ['uses' => 'UserController@index']);
    $router->get('/{id}', ['uses' => 'UserController@show']);
    $router->post('/', ['uses' => 'UserController@store']);
    $router->put('/{id}', ['uses' => 'UserController@update']);
    $router->delete('/{id}', ['uses' => 'UserController@destroy']);
});

$router->group(['prefix' => 'companies'], function () use ($router){
    $router->get('/', ['uses' => 'CompanyController@index']);
    $router->get('/{id}', ['uses' => 'CompanyController@show']);
    $router->post('/', ['uses' => 'CompanyController@store']);
    $router->put('/{id}', ['uses' => 'CompanyController@update']);
    $router->delete('/{id}', ['uses' => 'CompanyController@destroy']);
});

$router->group(['prefix' => 'assets'], function () use ($router){
    $router->get('/', 'AssetController@index');
    $router->get('/{id}','AssetController@show');
    $router->post('/', 'AssetController@store');
    $router->put('/{id}', 'AssetController@update');
    $router->delete('/{id}', 'AssetController@destroy');
});

$router->group(['prefix' => 'assethistory'], function () use ($router){
    $router->get('/', 'AssetHistoryController@index');
    $router->get('/{id}', 'AssetHistoryController@show');
    $router->post('/', 'AssetHistoryController@store');
    $router->put('/{id}', 'AssetHistoryController@update');
    $router->delete('/{id}', 'AssetHistoryController@destroy');
});