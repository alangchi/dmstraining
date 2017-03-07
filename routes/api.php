<?php
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::group(['prefix'=>'v1'],function() {

	Route::post('login',    'Api\APIController@login');
	Route::group(['middleware' => ['jwt.auth']], function() {
		Route::post('logout',    'Api\APIController@logout');
		Route::post('histories','Api\APIController@APIHistories');
		
		Route::post('change_status/{id}',  'historiesController@sendMessages');
		Route::post('approve_borrow/{id}', 'historiesController@approveDeviceBorrow');
		Route::post('approve_return/{id}', 'historiesController@approveReturnDevices');
		
		Route::post('list_devices',       'Api\APIController@listDevices');
		Route::post('request_device/{id}','Api\APIController@requestDevice');

		Route::get('show_details','Api\APIController@showAPIDevice');
		Route::post('store_device',      'historiesController@storeDevice');
		Route::post('edit_device/{id}',  'HomeController@updateDevice');
		Route::post('delete_device/{id}','Api\APIController@deleteDevice');

		Route::post('search_device',      'HomeController@searchDeviceAPI');
	});
});