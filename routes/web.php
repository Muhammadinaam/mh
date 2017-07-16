<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware'=>['web','\crocodicstudio\crudbooster\middlewares\CBBackend'],'prefix'=>config('crudbooster.ADMIN_PATH')], function () {
				
	Route::get('opd_visits/{id}/print', 'AdminOpdVisitsController@print_opd_visit');


	Route::get('reports/total_collection_report', 'ReportsController@totalCollectionReport');
	Route::get('reports/collection_by_users', 'ReportsController@collectionByUsers');

});
