<?php

$router->group(['prefix' => 'auth'], function () use ($router) {
    $router->post('login', 'AuthController@login');
    $router->post('register', 'AuthController@register');
});

$router->group(['prefix' => 'api/user', 'middleware' => ['jwt.auth', 'user.auth']], function () use ($router) {
    $router->get('{username}', 'UserController@show');
    $router->post('{username}', 'UserController@update');
});
