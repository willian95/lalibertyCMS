<?php

use Illuminate\Support\Facades\Route;

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
    return view('login');
})->middleware("guest");

Route::get('/home', function () {
    return view('dashboard');
})->middleware("auth");

Route::post("login", "LoginController@login");
Route::get("logout", "LoginController@logout")->name("logout");

Route::get("/category", "CategoryController@index")->name("category");
Route::post("category/store", "CategoryController@store");
Route::get("/category/fetch/{page}", "CategoryController@fetch");
Route::post("/category/update", "CategoryController@update");
Route::post("/category/delete", "CategoryController@delete");
Route::get("/category/all", "CategoryController@all");

Route::get("/size", "SizeController@index")->name("size");
Route::post("/size/store", "SizeController@store");
Route::get("/size/fetch/{page}", "SizeController@fetch");
Route::post("/size/update", "SizeController@update");
Route::post("/size/delete", "SizeController@delete");
Route::get("/size/all", "SizeController@all");

Route::get("/color", "ColorController@index")->name("color");
Route::post("/color/store", "ColorController@store");
Route::get("/color/fetch/{page}", "ColorController@fetch");
Route::post("/color/update", "ColorController@update");
Route::post("/color/delete", "ColorController@delete");
Route::get("/color/all", "ColorController@all");

Route::get("/products/create", "ProductController@create")->name("product.create");
Route::get("/products/list", "ProductController@list")->name("product.list");
Route::post("/products/store", "ProductController@store");
Route::post("/products/delete", "ProductController@delete");
Route::post("/products/update", "ProductController@update");
Route::get("/products/fetch/{page}", "ProductController@fetch");
Route::get("/products/edit/{id}", "ProductController@edit");

Route::get("/sales", "SaleController@index")->name("sales");
Route::get("/sales/fetch/{fetch}", "SaleController@fetch");
Route::get("/sales/excel", "SaleController@excelExport");
Route::get("/sales/csv", "SaleController@csvExport");

Route::get("/admin-email", "AdminMailController@index")->name("admin.email");
Route::post("admin-email/store", "AdminMailController@store");
Route::get("/admin-email/fetch", "AdminMailController@fetch");
Route::post("/admin-email/update", "AdminMailController@update");
Route::post("/admin-email/delete", "AdminMailController@delete");
