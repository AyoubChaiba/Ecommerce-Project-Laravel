<?php

use App\Http\Controllers\Admin\adminController;
use App\Http\Controllers\admin\BrandsController;
use App\Http\Controllers\admin\categoriesController;
use App\Http\Controllers\admin\homeAdminController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\subCategoryController;
use App\Http\Controllers\admin\TempImagesController;
use App\Http\Controllers\front\homeController;
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


Route::group(['prefix' => '/'] , function() {
    Route::get('/', [homeController::class, 'index'])->name('home.index');
});


Route::group(['prefix' => 'admin'], function () {
    Route::group(['middleware' => 'admin.guest'], function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.show');
        Route::post('/', [AdminController::class, 'login'])->name('admin.login');
    });
    Route::group(["middleware" => "admin.auth"], function () {

        // dashboard route
        Route::get('/dashboard', [HomeAdminController::class, "index"])->name('admin.dashboard');

        // logout
        Route::get('/logOut', [HomeAdminController::class, "logout"])->name('admin.logOut');

        // category routes
        Route::group(['prefix' => 'category'], function () {
            Route::get('/', [CategoriesController::class, 'index'])->name('category.index');
            Route::get('/create', [CategoriesController::class, 'create'])->name('category.create');
            Route::post('/', [CategoriesController::class, 'store'])->name('category.store');
            Route::get('/{id}', [CategoriesController::class, 'edit'])->name('category.edit');
            Route::put('/{id}', [CategoriesController::class, 'update'])->name('category.update');
            Route::delete('/{id}', [CategoriesController::class, 'delete'])->name('category.delete');
        });

        // Tamp image
        Route::post('temp-image', [TempImagesController::class, 'index'])->name('temp-image');

        // sub category routes
        Route::group(['prefix' => 'sub-category'], function () {
            Route::get('/', [subCategoryController::class, 'index'])->name('sub-category.index');
            Route::get('/create', [subCategoryController::class, 'create'])->name('sub-category.create');
            Route::post('/', [subCategoryController::class, 'store'])->name('sub-category.store');
            Route::get('/{id}', [subCategoryController::class, 'edit'])->name('sub-category.edit');
            Route::put('/{id}', [subCategoryController::class, 'update'])->name('sub-category.update');
            Route::delete('/{id}', [subCategoryController::class, 'delete'])->name('sub-category.delete');
        });

        // brands routes
        Route::group(['prefix' => 'brands'], function () {
            Route::get('/', [BrandsController::class, 'index'])->name('brands.index');
            Route::get('/create', [BrandsController::class, 'create'])->name('brands.create');
            Route::post('/', [BrandsController::class, 'store'])->name('brands.store');
            Route::get('/{id}', [BrandsController::class, 'edit'])->name('brands.edit');
            Route::put('/{id}', [BrandsController::class, 'update'])->name('brands.update');
            Route::delete('/{id}', [BrandsController::class, 'destroy'])->name('brands.delete');
        });

        // products routes
        Route::group(['prefix' => 'products'], function () {
            Route::get('/', [ProductController::class, 'index'])->name('products.index');
            Route::get('/create', [ProductController::class, 'create'])->name('products.create');
            Route::get('/subcategory', [ProductController::class, 'productSubcategory'])->name('get.subcategory');
            Route::post('/', [ProductController::class, 'store'])->name('products.store');
            Route::get('/{id}', [ProductController::class, 'edit'])->name('products.edit');
            Route::put('/{id}', [ProductController::class, 'update'])->name('products.update');
            Route::delete('/{id}', [ProductController::class, 'destroy'])->name('products.delete');
        });
    });
});


