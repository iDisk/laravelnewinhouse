<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Aqui se describen las rutas de API para la Aplicacion se usara API REST
|
*/

Route::group(['prefix' => 'v1'], function () {
	Route::match(['get', 'post'],'/','Api\ApiController@versionApi');

	Route::post('login','Api\ApiController@login');
	Route::post('changepass','Api\ApiController@changePass');
	Route::post('device','Api\ApiController@registerPush');

});

