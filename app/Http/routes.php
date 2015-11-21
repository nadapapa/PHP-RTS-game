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
use App\Building;

Route::get('/', ['middleware' => 'guest', function () {
	return view('welcome');
}]);

// Authentication routes...
Route::post('auth/login', 'Auth\AuthController@postLogin');

Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

// email activation route
Route::get('auth/verify/{id}', 'Auth\AuthController@getValidate');

// Password reset link request routes...
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

// social registration and login
Route::get('auth/{provider}', ['uses' => 'Auth\AuthController@redirectToProvider', 'as' => 'social.login']);
Route::get('auth/login/{provider}', 'Auth\AuthController@handleProviderCallback');




Route::group(['middleware' => 'auth'], function () {

	Route::post('setup', 'SetupController@postSetup');
	Route::get('setup', 'SetupController@getSetup');
});

// routes defended by auth middleware

Route::group(['middleware' => ['auth', 'setup']], function () {

	Route::get('home', 'HomeController@getHome');

    // map routes
//    Route::get('map/x{x}y{y}', 'MapController@getMapCoord');
    Route::get('map/get_cities', 'MapController@getCities');
    Route::get('map/get_armies', 'MapController@getArmies');
    Route::get('map/get_hex_data', 'MapController@getHexData');
    Route::get('map/get_city_data', 'MapController@getCityData');
    Route::get('map/get_army_data', 'MapController@getArmyData');
    Route::get('map/get_path', 'MapController@getPath');

    Route::get('map/{coord?}', 'MapController@getMap');

//    Route::post('map', 'MapController@ajaxMap');
//    Route::post('map/army', 'MapController@ajaxArmy');

    // city routes
	Route::get('city/{id}', 'CityController@getCity');

    // build routes
    Route::get('city/{city_id}/slot/{slot_num}', 'BuildingController@getBuild');
    Route::post('city/{city_id}/slot/{slot_num}/build', 'BuildingController@postBuild');

    // all buildings
    Route::get('city/{city_id}/slot/{slot_num}/building/{building_id}', 'BuildingController@getBuilding');
    Route::post('city/{city_id}/slot/{slot_num}/building/{building_id}/workers', 'BuildingController@postSetWorkers');
    Route::post('city/{city_id}/slot/{slot_num}/building/{building_id}/heal', 'BuildingController@postHeal');
    Route::get('city/{city_id}/slot/{slot_num}/building/{building_id}/levelup', 'BuildingController@getLevelUpBuilding');
    Route::get('city/{city_id}/slot/{slot_num}/building/{building_id}/delete', 'BuildingController@getDeleteBuilding');

    // forum
    Route::get('city/{city_id}/slot/{slot_num}/building/{building_id}/worker', 'ForumController@getMakeWorker');
    Route::get('city/{city_id}/slot/{slot_num}/building/{building_id}/settler', 'ForumController@getMakeSettler');

    // barracks
    Route::post('city/{city_id}/slot/{slot_num}/building/{building_id}/train', 'BarrackController@postTrainUnit');

//	Route::get('city/{city_id}/newcity', 'CityController@getNewCity');


});