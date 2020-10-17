<?php

$router->group(['prefix' => 'auth'], function () use ($router) {
    $router->post('login', 'AuthController@login');
    $router->post('register', 'AuthController@register');
});

$router->group(['prefix' => 'api/user', 'middleware' => 'jwt.auth'], function () use ($router) {
    $router->get('{id}', 'UserController@show');
    $router->put('{id}', 'UserController@update');
});
