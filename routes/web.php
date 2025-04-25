<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukService\ProductController;
use App\Http\Controllers\InventoryService\InventoryController;
use App\Models\Inventory;

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

Route::get('/add-produk', function () {
    return view('add_product');
});


Route::get('/edit-produk/{id}', function ($id) {
    return view('_product', ['id' => $id]);
});



Route::get('/order', function () {
    return view('order');
});

Route::get('/register', function () {
    return view('register');
});
Route::get('/add-stok', function () {
    return view('add-stok');
});

Route::get('/edit-product/{id}', [ProductController::class, 'edit'])->name('products.edit');
Route::get('/add-stok/{id}', [InventoryController::class, 'edit'])->name('inventory.edit');

