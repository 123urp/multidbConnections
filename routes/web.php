<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VendorsController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\SelectionContoller;
use App\Http\Middleware\Ensureconfigsession;

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
Route::middleware([Ensureconfigsession::class])->group(function () {
    Route::resource('/test', 'App\Http\Controllers\TestController');
    Route::post('/test/addOnDrive', 'App\Http\Controllers\TestController@addOnDrive')->name('test.addOnDrive');
    Route::get('/test/export/{name}', 'App\Http\Controllers\TestController@export')->name('test.export');
    Route::post('/test/checkViewName', 'App\Http\Controllers\TestController@checkViewName')->name('test.checkViewName');
    Route::get('/test/displayTables/{name}', 'App\Http\Controllers\TestController@displayTables')->name('test.displayTables');
    Route::get('/test/getViewTables/{name}', 'App\Http\Controllers\TestController@getViewTables')->name('test.viewTable');
});
Route::get('/selection/expire', 'App\Http\Controllers\SelectionContoller@expire')->name('selection.expire');
Route::resource('/selection', 'App\Http\Controllers\SelectionContoller');

require __DIR__.'/auth.php';
