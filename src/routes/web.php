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

$app->get('/', function () use ($app) {
    return $app->version();
});

$app->group(['middleware' => 'auth', 'prefix' => 'admin'], function () use ($app) {
    $app->group(['prefix' => 'posts'], function () use ($app) {
        $app->get('', 'AdminPostController@all');
        $app->post('', 'AdminPostController@create');
        $app->get('{post_id}', 'AdminPostController@get');
        $app->put('{post_id}', 'AdminPostController@update');
        $app->delete('{post_id}', 'AdminPostController@remove');
    });
});
