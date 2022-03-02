<?php
/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
    return response()->json(['status' => 'OK']);
});


$router->get('player', 'PlayerController@index');
$router->post('player', 'PlayerController@store');
$router->get('player/{id}', 'PlayerController@show');
$router->put('player/{id}', 'PlayerController@update');
$router->delete('player/{id}', 'PlayerController@destroy');

