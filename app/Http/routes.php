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

    $api->post('password', 'Auth\PasswordResetController@postPasswordReset');
    $api->post('password/{token}', 'Auth\PasswordResetController@postNewPassword');


    $api->get('images/upload', 'ImageController@test');
    $api->post('images/upload', 'ImageController@uploadImage');

});

//protected routes with JWT (must be logged in)
$api->group(['middleware' => ['api', 'api.auth']], function ($api) {
    /**
     * @var \Dingo\Api\Routing\Router $api
     */

    $api->get('languages', 'Cms\LanguageController@index');
    $api->get('languages/published', 'Cms\LanguageController@publishedIndex');
    $api->get('languages/enabled', 'Cms\LanguageController@enabledIndex');
    $api->get('languages/default', 'Cms\LanguageController@defaultLanguage');
    $api->put('languages/{id}', 'Cms\LanguageController@update');

    $api->get('filter', 'Cms\FilterController@index');

    $api->get('categories', 'Cms\CategoryController@index');
    $api->get('categories/{id}', ['uses' => 'Cms\CategoryController@show']);
    $api->post('categories', 'Cms\CategoryController@create');
    $api->put('categories/{id}', ['uses' => 'Cms\CategoryController@update']);
    $api->put('categories/{id}/toggleEnabled', 'Cms\CategoryController@toggleEnabled');

    $api->get('offer-translations', 'Cms\OfferTranslationController@index');
    $api->get('offer-translations/untranslated', 'Cms\OfferTranslationController@untranslatedIndex');
    $api->put('offer-translations/{id}', 'Cms\OfferTranslationController@translate');

    $api->get('offerDetail', 'Cms\OfferDetailController@index');
    $api->get('offer', 'Cms\OfferDetailController@show');

    $api->get('roles', 'Cms\RoleController@index');

    $api->get('users', 'Cms\UserController@index');
    $api->get('users/role/{role}', 'Cms\UserController@byRole');
    $api->get('users/ngo/{id}', 'Cms\UserController@byNgo');
    $api->get('users/{id}', 'Cms\UserController@show');
    $api->post('users', 'Cms\UserController@create');
    $api->put('users/{id}', 'Cms\UserController@update');
    $api->delete('users/{id}', 'Cms\UserController@bulkRemove');

    $api->get('ngos', 'Cms\NgoController@index');
    $api->get('ngo', 'Cms\NgoController@show');
    $api->post('ngos', 'Cms\NgoController@create');
    $api->put('ngos/{id}', 'Cms\NgoController@update');
    $api->put('ngo/{id}', 'Cms\NgoController@update');
    $api->put('ngos/{id}/togglePublished', 'Cms\NgoController@togglePublished');

    $api->get('offer/autocomplete/{search}', 'Cms\OfferController@autocomplete');
    $api->post('offer', 'Cms\OfferController@create');
    $api->get('offers', 'Cms\OfferController@index');
    $api->patch('offers/{ids}', 'Cms\OfferController@bulkAssign');
    $api->get('offers/{id}', 'Cms\OfferController@show');
    $api->put('offers/{id}/toggleEnabled', 'Cms\OfferController@toggleEnabled');

});
