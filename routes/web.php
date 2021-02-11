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

Route::get("/category", "CategoryController@index")->name("category")->middleware("auth");
Route::post("category/store", "CategoryController@store")->middleware("auth");
Route::get("/category/fetch/{page}", "CategoryController@fetch")->middleware("auth");
Route::post("/category/update", "CategoryController@update")->middleware("auth");
Route::post("/category/delete", "CategoryController@delete")->middleware("auth");
Route::get("/category/all", "CategoryController@all")->middleware("auth");

Route::get("/size", "SizeController@index")->name("size")->middleware("auth");
Route::post("/size/store", "SizeController@store")->middleware("auth");
Route::get("/size/fetch/{page}", "SizeController@fetch")->middleware("auth");
Route::post("/size/update", "SizeController@update")->middleware("auth");
Route::post("/size/delete", "SizeController@delete")->middleware("auth");
Route::get("/size/all", "SizeController@all")->middleware("auth");

Route::get("/color", "ColorController@index")->name("color")->middleware("auth");
Route::post("/color/store", "ColorController@store")->middleware("auth");
Route::get("/color/fetch/{page}", "ColorController@fetch")->middleware("auth");
Route::post("/color/update", "ColorController@update")->middleware("auth");
Route::post("/color/delete", "ColorController@delete")->middleware("auth");
Route::get("/color/all", "ColorController@all")->middleware("auth");

Route::get("/products/create", "ProductController@create")->name("product.create")->middleware("auth");
Route::get("/products/list", "ProductController@list")->name("product.list")->middleware("auth");
Route::post("/products/store", "ProductController@store")->middleware("auth");
Route::post("/products/delete", "ProductController@delete")->middleware("auth");
Route::post("/products/update", "ProductController@update")->middleware("auth");
Route::get("/products/fetch/{page}", "ProductController@fetch")->middleware("auth");
Route::get("/products/edit/{id}", "ProductController@edit")->middleware("auth");
Route::get("/products/excel", "ProductController@excelExport")->middleware("auth");
Route::get("/products/csv", "ProductController@csvExport")->middleware("auth");

Route::get("/blogs/create", "BlogController@create")->name("blog.create")->middleware("auth");
Route::get("/blogs/list", "BlogController@list")->name("blog.list")->middleware("auth");
Route::post("/blogs/store", "BlogController@store")->middleware("auth");
Route::post("/blogs/delete", "BlogController@delete")->middleware("auth");
Route::post("/blogs/update", "BlogController@update")->middleware("auth");
Route::get("/blogs/fetch/{page}", "BlogController@fetch")->middleware("auth");
Route::get("/blogs/edit/{id}", "BlogController@edit")->middleware("auth");

Route::get("/sales", "SaleController@index")->name("sales")->middleware("auth");
Route::get("/sales/fetch/{fetch}", "SaleController@fetch")->middleware("auth");
Route::get("/sales/excel", "SaleController@excelExport")->middleware("auth");
Route::get("/sales/csv", "SaleController@csvExport")->middleware("auth");
Route::post("send/tracking", "SaleController@sendTracking")->middleware("auth");

Route::get("/admin-email", "AdminMailController@index")->name("admin.email")->middleware("auth");
Route::post("admin-email/store", "AdminMailController@store")->middleware("auth");
Route::get("/admin-email/fetch", "AdminMailController@fetch")->middleware("auth");
Route::post("/admin-email/update", "AdminMailController@update")->middleware("auth");
Route::post("/admin-email/delete", "AdminMailController@delete")->middleware("auth");

Route::get("/works/create", "WorkController@create")->name("work.create")->middleware("auth");
Route::get("/works/list", "WorkController@list")->name("work.list")->middleware("auth");
Route::post("/works/store", "WorkController@store")->middleware("auth");
Route::post("/works/delete", "WorkController@delete")->middleware("auth");
Route::post("/works/update", "WorkController@update")->middleware("auth");
Route::get("/works/fetch/{page}", "WorkController@fetch")->middleware("auth");
Route::get("/works/edit/{id}", "WorkController@edit")->middleware("auth");

Route::get("/blogs/create", "BlogController@create")->name("blog.create")->middleware("auth");
Route::get("/blogs/list", "BlogController@list")->name("blog.list")->middleware("auth");
Route::post("/blogs/store", "BlogController@store")->middleware("auth");
Route::post("/blogs/delete", "BlogController@delete")->middleware("auth");
Route::post("/blogs/update", "BlogController@update")->middleware("auth");
Route::get("/blogs/fetch/{page}", "BlogController@fetch")->middleware("auth");
Route::get("/blogs/edit/{id}", "BlogController@edit")->middleware("auth");

Route::get("order/index", "HomeOrderController@index")->name("order.index")->middleware("auth");
Route::get("order/fetch/works", "HomeOrderController@fetchWorks");
Route::get("order/fetch/fashion-merch", "HomeOrderController@fetchFashionMerch");
Route::get("order/fetch/products", "HomeOrderController@fetchProducts");
Route::get("order/fetch/blogs", "HomeOrderController@fetchBlogs");
Route::get("order/fetch/elements", "HomeOrderController@fetchElements");
Route::post("order/store", "HomeOrderController@store");
Route::post("order/delete", "HomeOrderController@delete");
Route::post("order/update", "HomeOrderController@update");

Route::get("clear-cloudinary", function(){

    $images = Http::get("https://".env("CLOUDINARY_API").":".env("CLOUDINARY_SECRET")."@api.cloudinary.com/v1_1/laliberty/resources/image?max_results=100");
    foreach($images->json() as $imageCloud){
        
        if(!is_string($imageCloud)){
            
            foreach($imageCloud as $imageCl){

                $image = App\WorkImage::where("image", $imageCl["secure_url"])->first();
                if(!$image){
                    $image = App\Work::where("main_image", $imageCl["secure_url"])->first();
                    if(!$image){
                        $image = App\ProductSecondaryImage::where("image", $imageCl["secure_url"])->first();
                        if(!$image){
                            $image = App\Product::where("image", $imageCl["secure_url"])->first();
                            if(!$image){
                                $image = App\Blog::where("image", $imageCl["secure_url"])->first();
                            }
                        }
                    }
                }
    
                if(!$image){
    
                    //$response = Http::delete("https://".env("CLOUDINARY_API").":".env("CLOUDINARY_SECRET")."@api.cloudinary.com/v1_1/laliberty/resources/image/upload?prefix='".$imageCl["public_id"]."'");
                    dump($imageCl["public_id"]);
                }
            }

        }
        
    }
    //https://res.cloudinary.com/laliberty/image/upload/v1613022182/001_L_L_work_ncmafw.jpg

    //$images =Http::delete("https://".env("CLOUDINARY_API").":".env("CLOUDINARY_SECRET")."@api.cloudinary.com/v1_1/laliberty/resources/image?public_ids='001_L_L_work_ncmafw'");

    //dd($images->body());

})->middleware("auth");

route::get("test-email", function(){

    //dd(env("MAIL_USERNAME"), env("MAIL_PASSWORD"));

    $to_name = "Willian";
    $to_email = "rodriguezwillian95@gmail.com";
    $data = ["texto" => "test"];
    Mail::send("emails.test", $data, function($message) use ($to_name, $to_email) {

        $message->to($to_email, $to_name)->subject("Orden enviada. Rastrea tu orden!");
        $message->from(env("MAIL_FROM_ADDRESS"), env("MAIL_FROM_NAME"));

    });

});
