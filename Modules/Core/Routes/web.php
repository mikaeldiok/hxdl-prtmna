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
* Frontend Routes
*
* --------------------------------------------------------------------
*/
Route::group(['namespace' => '\Modules\Core\Http\Controllers\Frontend', 'as' => 'frontend.', 'middleware' => 'web', 'prefix' => ''], function () {

    /*
     *
     *  Cores Routes
     *
     * ---------------------------------------------------------------------
     */
    $module_name = 'units';
    $controller_name = 'UnitsController';    
    Route::get("getunitopt/{id}", 
        ['as' => "$module_name.getunitopt", 'uses' => "$controller_name@getUnitOpt"])->middleware(['throttle:10,1']);;
   
});

/*
*
* Backend Routes
*
* --------------------------------------------------------------------
*/
Route::group(['namespace' => '\Modules\Core\Http\Controllers\Backend', 'as' => 'backend.', 'middleware' => ['web', 'auth', 'can:view_backend'], 'prefix' => 'admin'], function () {
    /*
    * These routes need view-backend permission
    * (good if you want to allow more than one group in the backend,
    * then limit the backend features by different roles or permissions)
    *
    * Note: Administrator has all permissions so you do not have to specify the administrator role everywhere.
    */

    /*
     *
     *  Units Routes
     *
     * ---------------------------------------------------------------------
     */
    $module_name = 'units';
    $controller_name = 'UnitsController';
    Route::get("$module_name/index_list", ['as' => "$module_name.index_list", 'uses' => "$controller_name@index_list"]);
    Route::get("$module_name/index_data", ['as' => "$module_name.index_data", 'uses' => "$controller_name@index_data"]);
    Route::get("$module_name/trashed", ['as' => "$module_name.trashed", 'uses' => "$controller_name@trashed"]);
    Route::patch("$module_name/trashed/{id}", ['as' => "$module_name.restore", 'uses' => "$controller_name@restore"]);
    Route::delete("$module_name/purge/{id}", ['as' => "$module_name.purge", 'uses' => "$controller_name@purge"]);
    Route::post("$module_name/import", ['as' => "$module_name.import", 'uses' => "$controller_name@import"]);
    Route::resource("$module_name", "$controller_name");
});
