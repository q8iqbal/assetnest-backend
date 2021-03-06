<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->post('register', 'AuthController@register');
$router->post('login', 'AuthController@login');
$router->post('login/mobile', 'AuthController@loginMobile');
$router->get('logout', 'AuthController@logout');

$router->get('task', 'TaskController@index');
$router->get('task/{id}', 'TaskController@show');
$router->post('task', 'TaskController@store');
$router->put('task/{id}', 'TaskController@update');
$router->delete('task/{id}', 'TaskController@delete');


$router->group(['prefix' => 'users'], function () use ($router){
    $router->get('/', ['uses' => 'UserController@index']);
    $router->get('/erased', ['uses' => 'UserController@erased']);
    $router->get('/{id}', ['uses' => 'UserController@show']);
    $router->get('/{id}/assets', ['uses' => 'UserController@assetHolded']);
    $router->get('/{id}/history', ['uses' => 'UserController@assetHistory']);
    $router->post('/', ['uses' => 'UserController@store']);
    $router->post('/image', ['uses' => 'FileController@userImage']);
    $router->put('/{id}', ['uses' => 'UserController@update']);
    $router->put('/{id}/password', ['uses' => 'UserController@changePassword']);
    $router->put('/{id}/restore', ['uses' => 'UserController@restore']);
    $router->delete('/{id}', ['uses' => 'UserController@destroy']);
});

$router->group(['prefix' => 'companies'], function () use ($router){
    $router->get('/', ['uses' => 'CompanyController@show']);
    $router->post('/image', ['uses' => 'FileController@companyImage']);
    $router->put('/', ['uses' => 'CompanyController@update']);
});

$router->group(['prefix' => 'assets'], function () use ($router){
    $router->get('/count', ['uses' => 'AssetController@count']);
    $router->get('/', ['uses' => 'AssetController@index' ]);
    $router->get('/{id}',['uses' => 'AssetController@show']);
    $router->get('/{id}/attachment', ['uses' => 'AssetController@attachment']);
    $router->get('/{id}/history', ['uses' => 'AssetController@assetHistory']);
    $router->post('/{id}/attachment', ['uses' => 'FileController@assetAttachment']);
    $router->post('/image', ['uses' => 'FileController@assetImage']);
    $router->post('/', ['uses' => 'AssetController@store']);
    $router->put('/{id}', ['uses' => 'AssetController@update']);
    $router->delete('/{id}', ['uses' => 'AssetController@destroy']);
});

$router->group(['prefix' => 'histories'], function () use ($router){
    $router->get('/', ['uses' => 'AssetHistoryController@index']);
    $router->delete('/{id}', ['uses' => 'AssetHistoryController@destroy']);
});