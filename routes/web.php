<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->post('register', 'AuthController@register');
$router->get('login', 'AuthController@login');
$router->get('logout', 'AuthController@logout');

$router->group(['prefix' => 'users'], function () use ($router){
    $router->get('/', ['uses' => 'UserController@index']);
    $router->get('/erased', ['uses' => 'UserController@erased']);
    $router->get('/{id}', ['uses' => 'UserController@show']);
    $router->get('/{id}/assets', ['uses' => 'UserController@assetHolded']);
    $router->get('/{id}/history', ['uses' => 'UserController@assetHistory']);
    $router->post('/', ['uses' => 'UserController@store']);
    $router->post('/image', ['uses' => 'FileController@userImage']);
    $router->put('/{id}', ['uses' => 'UserController@update']);
    $router->put('/{id}/restore', ['uses' => 'UserController@restore']);
    $router->delete('/{id}', ['uses' => 'UserController@destroy']);
});

$router->group(['prefix' => 'companies'], function () use ($router){
    $router->get('/{id}', ['uses' => 'CompanyController@show']);
    $router->post('/image', ['uses' => 'FileController@companyImage']);
    $router->put('/{id}', ['uses' => 'CompanyController@update']);
});

$router->group(['prefix' => 'assets'], function () use ($router){
    $router->get('/', 'AssetController@index');
    $router->get('/{id}','AssetController@show');
    $router->get('/{id}/attachment', ['uses' => 'AssetController@attachment']);
    $router->post('/{id}/attachment', ['uses' => 'FileController@assetAttachment']);
    $router->post('/image', ['uses' => 'FileController@assetImage']);
    $router->post('/', 'AssetController@store');
    $router->put('/{id}', 'AssetController@update');
    $router->delete('/{id}', 'AssetController@destroy');
});