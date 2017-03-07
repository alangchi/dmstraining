<?php

Route::get('/', function () {
    return redirect('welcome');
});

Route::get('welcome', 'HomeController@homePage');

Auth::routes();
//users auth
Route::get('login', 'Auth\LoginController@getLogin');
Route::post('login','Auth\LoginController@login');
Route::get('logout','Auth\LoginController@logout');

Route::get('editProfiles/{id}', 'Auth\AuthController@editProfiles')->name('profile');
Route::post('editProfiles/{id}', 'Auth\AuthController@postEditProfiles')->name('saveProfile');

//Route for Management
Route::group(['middleware'=>'auth'],function() {
	Route::get('/dashboard',         'HomeController@index');
	Route::get('/device/edit/{id}',  'HomeController@getEdit');
	Route::post('/device/edit/{id}', 'HomeController@updateDevice');
	Route::get('/device/delete/{id}','HomeController@getDelete');
});
//Search
Route::group(['prefix'=>'devices','middleware'=>'auth'],function() {
	Route::get('/{deviceID}/show_device_details', 'HomeController@showDeviceDetails');
	Route::get('histories',['as'     =>'devices.historiesGet','uses'       =>'historiesController@getHistories']);
	Route::get('add',['as'           =>'devices.historiesGet','uses'       =>'historiesController@getAdd']);
	Route::post('add',['as'          =>'devices.historiesPost','uses'      =>'historiesController@storeDevice']);
	Route::get('/update/{id}', ['as' =>'devices.historiesGetUpdate','uses' =>'historiesController@approveDeviceBorrow']);
	Route::get('/pay/{id}',['as'     =>'devices.postPayDevices','uses'     =>'historiesController@approveReturnDevices']);
	Route::get('/inbox/{id}',['as'   =>'devices.postInboxMessages','uses'  =>'historiesController@sendMessages']);
});
//borrowers
Route::group(['prefix'=>'borrowers','middleware'=>'auth'],function() {
	Route::group(['prefix'=>'devices'], function() {
		
		Route::get('',  ['as'     =>'borrowers.devices.search',   'uses' =>'DevicesController@SeasrchDeviecs']);
		Route::get('dashboard',['as'=>'borrowers.devices.dashboard','uses' =>'DevicesController@Deviecs']);

		Route::get('',['as'      =>'borrowers.devices.historiesSearch','uses'  =>'DevicesController@getSearchHistories']);
		Route::get('histories',['as' =>'borrowers.devices.historiesGet','uses'  =>'DevicesController@getHistories']);

		Route::post('/borrows/{id}',['as'=>'borrowers.devices.postBorrowDevices','uses' =>'DevicesController@postBorrow']);	
		Route::post('/update/{id}',['as' =>'borrowers.devices.postUpdateTimeline','uses'=>'DevicesController@updateTimeline']);
	});
});

//management users
Route::group(['prefix'=>'users','middleware'=>'auth'],function() {

	Route::get('create_user',     ['as'=>'admin.users.get_create_user', 'uses'=>'UserController@getCreateUser']);
	Route::post('create_user',    ['as'=>'admin.users.post_create_user','uses'=>'UserController@postCreateUser']);

	Route::get('edit_user/{id}',  ['as'=>'admin.users.get_edit_user',   'uses'=>'UserController@ShowUser']);
	Route::post('edit_user/{id}', ['as'=>'admin.users.post_edit_user',  'uses'=>'UserController@updateUser']);
	Route::get('delete_user/{id}',['as'=>'admin.users.destroy_user',    'uses'=>'UserController@destroyUser']);

	Route::get('',           ['as'=>'admin.users.search',      'uses'=>'UserController@searchUsers']);
	Route::get('list_users', ['as'=>'admin.users.list_users',  'uses'=>'UserController@TestSearchUsers']);
});

//Send mail
Route::group(['middleware'=>'auth'],function() {
	Route::get('send-email',  'UserController@getSendEmail')->name('getSendEmail');
	Route::post('send-email', 'UserController@postSendEmail')->name('postSendEmail');
});

//test email;
use App\Mail\OrderShipped;
Route::get('testmail', function() {
	Mail::send('users.mailsent', ['data' => 'A Chi'], function() {  
		Mail::to("chi.al@neo-lab.vn")->send(new OrderShipped());
    });
});

//management device infos
Route::group(['prefix'=>'device_infos','middleware'=>'auth'],function() {
	Route::get('list_device_info',      ['as'=>'admin.device_infos.list',                     'uses'=>'DeviceInfomationController@listDeviceInfo']);

	Route::get('create_device_info',     ['as'=>'admin.device_infos.get_create_device_infos', 'uses'=>'DeviceInfomationController@createDeviceInfo']);
	Route::post('create_device_info',    ['as'=>'admin.device_infos.post_create_device_infos','uses'=>'DeviceInfomationController@storeDeviceInfo']);

	Route::get('edit_device_info/{device_info_id}',  ['as'=>'admin.device_infos.get_edit_device_infos',   'uses'=>'DeviceInfomationController@showDeviceInfo']);
	Route::post('edit_device_info/{device_info_id}', ['as'=>'admin.device_infos.post_edit_device_infos',  'uses'=>'DeviceInfomationController@updateDeviceInfo']);
	Route::get('destroy_device_info/{device_info_id}',['as'=>'admin.device_infos.destroy_device_infos',    'uses'=>'DeviceInfomationController@destroyDeviceInfo']);
});


//test
Route::get('search_device',      'HomeController@searchDeviceAPI');
Route::get('show_details','Api\APIController@showAPIDevice');
Route::post('histories','Api\APIController@APIHistories');