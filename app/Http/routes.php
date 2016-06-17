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

    $api->get('categories', 'Cms\CategoryController@index');

    $api->get('categories/{id}', ['uses' => 'Cms\CategoryController@show'])->where('id', '[0-9]+');
    $api->get('categories/{slug}', ['uses' => 'Cms\CategoryController@bySlug'])->where(['slug' => '[a-z][-a-z0-9]*$']);
    $api->get('categories/{id}/offers', ['uses' => 'Cms\CategoryController@offers']);

    $api->get('ngo/{id}', 'Cms\NgoController@show');
    $api->get('offers', 'Cms\OfferController@index');
    $api->get('offer/autocomplete/{search}', 'Cms\OfferController@autocomplete');

    $api->get('offerDetail', 'Cms\OfferDetailController@index');
    $api->get('offers/{id}', 'Cms\OfferController@show');

    $api->get('languages/enabled', 'Cms\LanguageController@enabledIndex');


});

//protected routes with JWT (must be logged in)
$api->group(['middleware' => ['api', 'api.auth']], function ($api) {
    /**
     * @var \Dingo\Api\Routing\Router $api
     */

    $api->get('offer-translations', 'Cms\OfferTranslationController@index');
    $api->get('offer-translations/untranslated', 'Cms\OfferTranslationController@untranslatedIndex');
    $api->put('offer-translations/{id}', 'Cms\OfferTranslationController@translate');

    $api->get('category-translations', 'Cms\CategoryTranslationController@index');
    $api->get('category-translations/untranslated', 'Cms\CategoryTranslationController@untranslatedIndex');
    $api->put('category-translations/{id}', 'Cms\CategoryTranslationController@translate');

    $api->get('ngo-translations', 'Cms\NgoTranslationController@index');
    $api->get('ngo-translations/untranslated', 'Cms\NgoTranslationController@untranslatedIndex');
    $api->put('ngo-translations/{id}', 'Cms\NgoTranslationController@translate');

    $api->get('filter-translations', 'Cms\FilterTranslationController@index');
    $api->get('filter-translations/untranslated', 'Cms\FilterTranslationController@untranslatedIndex');
    $api->put('filter-translations/{id}', 'Cms\FilterTranslationController@translate');

    $api->get('languages/published', 'Cms\LanguageController@publishedIndex');
    $api->get('languages/default', 'Cms\LanguageController@defaultLanguage');
    
    $api->get('users/me', 'Cms\UserController@me');

    $api->post('offers', 'Cms\OfferController@create');
    $api->put('offers/{id}', 'Cms\OfferController@update');
    $api->delete('offers/{id}', 'Cms\OfferController@bulkRemove');

    $api->get('ngos/my', 'Cms\NgoController@my');
    $api->put('ngos/my/{id}', 'Cms\NgoController@update');


    $api->get('filters', 'Cms\FilterController@index');

    // FOR ADMINS AND NGO-admins
    $api->group(['middleware' => ['role:superadmin|admin|organisation-admin']], function ($api) {
        $api->post('users', 'Cms\UserController@create');
        $api->delete('users/{id}', 'Cms\UserController@bulkRemove');
        $api->get('ngoUsers', 'Cms\UserController@byNgo');
        $api->post('ngoUsers', 'Cms\UserController@createNgoUser');
        $api->put('ngoUsers/{id}/toggleAdmin', 'Cms\UserController@toggleAdmin');

    });

    // JUST FOR ADMINS
    $api->group(['middleware' => ['role:superadmin|admin']], function ($api) {

      $api->get('languages', 'Cms\LanguageController@index');
      $api->put('languages/{id}', 'Cms\LanguageController@update');

      $api->get('ngos', 'Cms\NgoController@index');
      $api->post('ngos', 'Cms\NgoController@create');
      $api->put('ngos/{id}', 'Cms\NgoController@update');
      $api->put('ngos/{id}/togglePublished', 'Cms\NgoController@togglePublished');

      $api->get('users', 'Cms\UserController@index');
      $api->get('users/role/{role}', 'Cms\UserController@byRole');

      $api->get('users/{id}', 'Cms\UserController@show');
      $api->put('users/{id}', 'Cms\UserController@update');

      $api->get('roles', 'Cms\RoleController@index');


      $api->post('categories', 'Cms\CategoryController@create');
      $api->put('categories/{id}', ['uses' => 'Cms\CategoryController@update']);
      $api->put('categories/{id}/toggleEnabled', 'Cms\CategoryController@toggleEnabled');
      $api->put('categories/{id}/move', 'Cms\CategoryController@move');

      $api->put('offers/{id}/toggleEnabled', 'Cms\OfferController@toggleEnabled');
      $api->patch('offers/{ids}', 'Cms\OfferController@bulkAssign');

      $api->put('filters/{id}/toggleEnabled', 'Cms\FilterController@toggleEnabled');
      $api->get('filters/{id}', ['uses' => 'Cms\FilterController@show']);
      $api->post('filters', 'Cms\FilterController@create');
      $api->put('filters/{id}', ['uses' => 'Cms\FilterController@update']);
    });
});
