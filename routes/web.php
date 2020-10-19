<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use Illuminate\Http\Request;

$router->post('login', 'AuthController@login');
$router->post('register', 'AuthController@register');
$router->get('logout', 'AuthController@logout');
$router->post('tes', function(Request $request){
    return response($request->all());
});


$router->group(['prefix' => 'users'], function () use ($router){
    $router->get('/', ['uses' => 'UserController@index']);
    $router->get('/thrash', ['uses' => 'UserController@thrash']);
    $router->get('/{id}', ['uses' => 'UserController@show']);
    $router->post('/', ['uses' => 'UserController@store']);
    $router->post('/image', ['uses' => 'FileController@userPicture']);
    $router->put('/{id}', ['uses' => 'UserController@update']);
    $router->put('/restore/{id}', ['uses' => 'UserController@restore']);
    $router->delete('/{id}', ['uses' => 'UserController@destroy']);
});

$router->group(['prefix' => 'companies'], function () use ($router){
    $router->get('/', ['uses' => 'CompanyController@index']);
    $router->get('/{id}', ['uses' => 'CompanyController@show']);
    $router->post('/image', ['uses' => 'FileController@companyLogo']);
    $router->post('/', ['uses' => 'CompanyController@store']);
    $router->put('/{id}', ['uses' => 'CompanyController@update']);
    $router->delete('/{id}', ['uses' => 'CompanyController@destroy']);
});

$router->group(['prefix' => 'assets'], function () use ($router){
    $router->get('/', 'AssetController@index');
    $router->get('/{id}','AssetController@show');
    // $router->get('/{id}/attachment', ['uses' => '']);
    $router->post('/{id}/attachment', ['uses' => 'FileController@assetAttachment']);
    $router->post('/image', ['uses' => 'FileController@assetPicture']);
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