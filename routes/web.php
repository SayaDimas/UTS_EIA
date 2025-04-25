<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukService\ProductController;

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', function () {
    return view('home');
});

Route::resource('products', ProductController::class);

Route::get('/add-produk', function () {
    return view('add_product');
});
Route::resource('products', ProductController::class);

Route::get('/edit-produk', function () {
    return view('_product');
});



Route::get('/order', function () {
    return view('order');
});

Route::get('/register', function () {
    return view('register');
});




