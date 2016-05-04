<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => ['web']], function () {

    Route::get('/', 'AngularController@serveApp');

    Route::get('/unsupported-browser', 'AngularController@unsupported');

});

$api->group(['middleware' => ['api']], function ($api) {
    /**
     * @var \Dingo\Api\Routing\Router $api
     */
    $api->controller('auth', 'Auth\AuthController');

    $api->get('language', 'Cms\LanguageController@index');
    $api->get('language/published', 'Cms\LanguageController@published');
    $api->post('language/{id}', 'Cms\LanguageController@update');

    $api->get('filter', 'Cms\FilterController@index');

    $api->get('category', 'Cms\CategoryController@index');
    $api->get('category/{id}', ['uses' => 'Cms\CategoryController@show']);
    $api->post('category', 'Cms\CategoryController@create');
    $api->post('category/{id}', ['uses' => 'Cms\CategoryController@update']);
});

//protected routes with JWT (must be logged in)
$api->group(['middleware' => ['api', 'api.auth']], function ($api) {
    /**
     * @var \Dingo\Api\Routing\Router $api
     */
});
