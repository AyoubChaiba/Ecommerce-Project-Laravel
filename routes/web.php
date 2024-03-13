<?php

use App\Http\Controllers\Admin\adminController;
use App\Http\Controllers\admin\homeAdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// Route::prefix('admin')->name('admin.')->group(function () {
//     Route::controller(adminController::class)->group(function () {
//         Route::get('/','index')->name('login');
//     });
// });


Route::group(['prefix' => 'admin'] , function () {
    Route::group(['middleware' => 'admin.guest'], function () {
        Route::get('/' , [adminController::class,'index'] )->name('admin.show');
        route::post('/', [adminController::class,'login'])->name('admin.login');
    });
    Route::group(["middleware" => "admin.auth" ], function (){
        Route::get('/dashboard' , [homeAdminController::class , "index"])->name('admin.dashboard');
        Route::get('/logOut' , [homeAdminController::class , "logout"])->name('admin.logOut');
    });
} );
