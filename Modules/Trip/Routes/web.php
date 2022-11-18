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

/*
*
* Auth Routes
*
* --------------------------------------------------------------------
*/
// Route::group(['namespace' => '\Modules\Trip\Http\Controllers\Auth', 'as' => 'auth.', 'middleware' => 'web', 'prefix' => ''], function () {
    
//     /*
//      *
//      *  Trips Routes
//      *
//      * ---------------------------------------------------------------------
//      */
//     $module_name = 'inspections';
//     $controller_name = 'InspectionsController'; 
    
//     Route::get("$module_name/login", ['as' => "$module_name.login", 'uses' => "$controller_name@showLoginForm"]);
//     Route::post("$module_name/login", ['as' => "$module_name.login", 'uses' => "$controller_name@login"]);
//     Route::get("$module_name/register", ['as' => "$module_name.register", 'uses' => "$controller_name@showRegisterForm"]);
//     Route::post("$module_name/register", ['as' => "$module_name.register", 'uses' => "$controller_name@register"]);
//     Route::get("$module_name/logout", ['as' => "$module_name.logout", 'uses' => "$controller_name@logout"]);
    
// });

/*
*
* Frontend Routes
*
* --------------------------------------------------------------------
*/
Route::group(['namespace' => '\Modules\Trip\Http\Controllers\Frontend', 'as' => 'frontend.', 'middleware' => ['web'], 'prefix' => ''], function () {

    /*
     *
     *  Trips Routes
     *
     * ---------------------------------------------------------------------
     */
    $module_name = 'inspections';
    $controller_name = 'InspectionsController';
    Route::get("$module_name/create-part-1", ['as' => "$module_name.create-part-1", 'uses' => "$controller_name@createPart1"]);
    Route::get("$module_name/store-part-1", ['as' => "$module_name.store-part-1", 'uses' => "$controller_name@storePart1"]);
    Route::resource("$module_name", "$controller_name");

});

/*
*
* Backend Routes
*
* --------------------------------------------------------------------
*/
Route::group(['namespace' => '\Modules\Trip\Http\Controllers\Backend', 'as' => 'backend.', 'middleware' => ['web', 'auth', 'can:view_backend'], 'prefix' => 'admin'], function () {
    /*
    * These routes need view-backend permission
    * (good if you want to allow more than one group in the backend,
    * then limit the backend features by different roles or permissions)
    *
    * Note: Administrator has all permissions so you do not have to specify the administrator role everywhere.
    */

    /*
     *
     *  Inspections Routes
     *
     * ---------------------------------------------------------------------
     */

    $module_name = 'inspections';
    $controller_name = 'InspectionsController';
    Route::get("$module_name/index_list", ['as' => "$module_name.index_list", 'uses' => "$controller_name@index_list"]);
    Route::get("$module_name/index_data", ['as' => "$module_name.index_data", 'uses' => "$controller_name@index_data"]);
    Route::get("$module_name/trashed", ['as' => "$module_name.trashed", 'uses' => "$controller_name@trashed"]);
    Route::patch("$module_name/trashed/{id}", ['as' => "$module_name.restore", 'uses' => "$controller_name@restore"]);
    Route::delete("$module_name/purge/{id}", ['as' => "$module_name.purge", 'uses' => "$controller_name@purge"]);
    Route::post("$module_name/get_inspection", ['as' => "$module_name.getinspection", 'uses' => "$controller_name@get_inspection"]);
    Route::post("$module_name/import", ['as' => "$module_name.import", 'uses' => "$controller_name@import"]);
    Route::resource("$module_name", "$controller_name");

    $module_name = 'days';
    $controller_name = 'DaysController';
    Route::get("$module_name/index_list", ['as' => "$module_name.index_list", 'uses' => "$controller_name@index_list"]);
    Route::get("$module_name/index_data", ['as' => "$module_name.index_data", 'uses' => "$controller_name@index_data"]);
    Route::get("$module_name/insertname", ['as' => "$module_name.pengawasLogin", 'uses' => "$controller_name@pengawasLogin"]);
    Route::get("$module_name/nameproccess", ['as' => "$module_name.pengawasLoginProccess", 'uses' => "$controller_name@pengawasLoginProccess"]);
    Route::get("$module_name/trashed", ['as' => "$module_name.trashed", 'uses' => "$controller_name@trashed"]);
    Route::patch("$module_name/trashed/{id}", ['as' => "$module_name.restore", 'uses' => "$controller_name@restore"]);
    Route::delete("$module_name/purge/{id}", ['as' => "$module_name.purge", 'uses' => "$controller_name@purge"]);
    Route::post("$module_name/get_day", ['as' => "$module_name.getday", 'uses' => "$controller_name@get_day"]);
    Route::post("$module_name/import", ['as' => "$module_name.import", 'uses' => "$controller_name@import"]);
    Route::resource("$module_name", "$controller_name");

    $module_name = 'cores';
    $controller_name = 'CoresController';
    Route::get("$module_name/trashed", ['as' => "$module_name.trashed", 'uses' => "$controller_name@trashed"]);
    Route::patch("$module_name/trashed/{id}", ['as' => "$module_name.restore", 'uses' => "$controller_name@restore"]);
    Route::delete("$module_name/purge/{id}", ['as' => "$module_name.purge", 'uses' => "$controller_name@purge"]);
    Route::resource("$module_name", "$controller_name");

});
