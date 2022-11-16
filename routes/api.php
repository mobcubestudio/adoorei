<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(\App\Http\Controllers\Api\ProductController::class)->group(function () {
    Route::get('/products', 'index')->name('api.clientes.list');
    Route::post('/products', 'store')->name('api.clientes.store');
    Route::get('/products/{id}', 'show')->name('api.clientes.show');
    Route::put('/products/{id}', 'update')->name('api.clientes.update');
    Route::delete('/products/{id}', 'destroy')->name('api.clientes.delete');

    Route::get('/search/namecategory/{name}/{category}', 'searchNameCategory')->name('api.clientes.search.namecategory');
    Route::get('/search/category/{category}', 'searchCategory')->name('api.clientes.search.category');
    Route::get('/search/withimage', 'searchWithImage')->name('api.clientes.search.withimage');
    Route::get('/search/withoutimage', 'searchWithoutImage')->name('api.clientes.search.withoutimage');
});
