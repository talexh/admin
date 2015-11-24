<?php
/*
* composer dump-autoload
* Run above command when you add a new controller to the module
*/
Route::group(array('prefix' => 'admin','before'=>'auth'), function () {
	Route::get('dash-board', 		array('uses' => 'App\Modules\Admin\Controllers\AdminController@dashboard'));
	Route::get('profile', 			array('uses' => 'App\Modules\Admin\Controllers\AdminController@profile'));
	Route::get('export', 			array('uses' => 'App\Modules\Admin\Controllers\AdminController@export'));
	Route::get('do-export', 			array('uses' => 'App\Modules\Admin\Controllers\AdminController@doexport'));
	Route::post('updateProfile',	array('uses' => 'App\Modules\Admin\Controllers\AdminController@updateProfile'));

	// Route for user management
	Route::get('users',  			array('as'=>'userlist',		'uses' => 'App\Modules\Admin\Controllers\UserController@index'));
	Route::get('users/edit/{id}', 	array('as'=>'useredit', 	'uses' => 'App\Modules\Admin\Controllers\UserController@edit'));
	Route::get('users/add', 			array('as'=>'useradd',		'uses' => 'App\Modules\Admin\Controllers\UserController@add'));
	Route::get('users/delete/{id}', 	array('as'=>'userdel',		'uses' => 'App\Modules\Admin\Controllers\UserController@delete'));
	Route::post('users/create', 		array('as'=>'usercreate',	'uses' => 'App\Modules\Admin\Controllers\UserController@create'));
	Route::post('users/update', 		array('as'=>'userupdate',	'uses' => 'App\Modules\Admin\Controllers\UserController@update'));

	// Route for news management
	Route::get('category', 			array('as'=>'categorylist', 	'uses'=>'App\Modules\Admin\Controllers\CategoryController@index'));
	Route::get('category/edit/{id}',	array('as'=>'categoryedit', 	'uses'=>'App\Modules\Admin\Controllers\CategoryController@edit'));
	Route::get('category/add', 			array('as'=>'categoryadd', 		'uses'=>'App\Modules\Admin\Controllers\CategoryController@add'));
	Route::post('category/update', 		array('as'=>'categoryupdate',	'uses'=>'App\Modules\Admin\Controllers\CategoryController@update'));
	Route::post('category/create', 		array('as'=>'categorycreate',	'uses'=>'App\Modules\Admin\Controllers\CategoryController@create'));
	Route::get('category/delete/{id}', 	array('as'=>'categorydel',		'uses'=>'App\Modules\Admin\Controllers\CategoryController@delete'));

	// Route for news management
	Route::get('news/list/{categoryId?}/{appId?}', 			array('as'=>'newslist', 	'uses'=>'App\Modules\Admin\Controllers\NewsController@index'));
	Route::get('news/edit/{id}',	array('as'=>'newsedit', 	'uses'=>'App\Modules\Admin\Controllers\NewsController@edit'));
	Route::get('news/add', 			array('as'=>'newsadd', 		'uses'=>'App\Modules\Admin\Controllers\NewsController@add'));
	Route::post('news/update', 		array('as'=>'newsupdate',	'uses'=>'App\Modules\Admin\Controllers\NewsController@update'));
	Route::post('news/create', 		array('as'=>'newscreate',	'uses'=>'App\Modules\Admin\Controllers\NewsController@create'));
	Route::get('news/delete/{id}', 	array('as'=>'newsdel',		'uses'=>'App\Modules\Admin\Controllers\NewsController@delete'));

	// Route for apps management
	Route::get('apps', 			array('as'=>'appslist', 	'uses'=>'App\Modules\Admin\Controllers\AppsController@index'));
	Route::get('apps/edit/{id}',	array('as'=>'appsedit', 	'uses'=>'App\Modules\Admin\Controllers\AppsController@edit'));
	Route::get('apps/add', 			array('as'=>'appsadd', 		'uses'=>'App\Modules\Admin\Controllers\AppsController@add'));
	Route::post('apps/update', 		array('as'=>'appsupdate',	'uses'=>'App\Modules\Admin\Controllers\AppsController@update'));
	Route::post('apps/create', 		array('as'=>'appscreate',	'uses'=>'App\Modules\Admin\Controllers\AppsController@create'));
	Route::get('apps/delete/{id}', 	array('as'=>'appsdel',		'uses'=>'App\Modules\Admin\Controllers\AppsController@delete'));

// 	Route::get('remind', array('uses' => 'RemindersController@getRemind'));
// 	Route::post('postRemind', array('uses' => 'RemindersController@postRemind'));

});
Route::get('/admin/login',  	array('as'=>'seclogin','uses' => 'App\Modules\Admin\Controllers\LoginController@login'));
Route::post('/admin/signIn',	array('as'=>'secsignin','uses' => 'App\Modules\Admin\Controllers\LoginController@signIn'));
Route::get('/admin/logout', 	array('as'=>'seclogout','uses' => 'App\Modules\Admin\Controllers\LoginController@logout'));
Route::post('/admin/communicate', 	array('as'=>'appcom','uses' => 'App\Modules\Admin\Controllers\CommunicateController@checkAndReqUpdate'));

// Custom 404 page
App::missing(function($exception) {
    return Response::view('content::404', array(), 404);
});

/* foreach (Config::get('content::channels') as $key => $channel) {
	Route::get('admin/content/' . $key, function() use ($channel) {
		return "<h1>Channel [{$channel['title']}]</h1>";
	});
} */
