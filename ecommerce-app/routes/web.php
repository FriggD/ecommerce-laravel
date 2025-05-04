<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

//
Route::get("/", [HomeController::class, 'index'])-> name('home');

Route::fallback(function() {
    return "Rota de fallback";
});
// [
// EQUIVALENTES
Route::view(uri:'/about', view:'about')->name('about');

// Route::get('/about', function() {
//     return view('about');
// });

// ]



// exemplos:

// Route::get(uri:'/product/{id}', action: function(string $id){
//     return "Product id = $id";
// });

// Route::get(uri:'/product/{category?}', action: function(string $category = null){
//     return "Product category = $category";
// });

// Route::get(uri:'/product/{id}', action: function(string $id){
//     return "Works! $id";
// }) -> whereNumber('id');


// Route::controller(CarController::class)->group(function(){
//     Route::get('/car', 'index');
// });

// Route::get('/car/invokable',CarController::class);
// Route::get('/car',[CarController::class, 'index']);

// Route::apiResources([
//     'cars'=> CarController::class,
//     'products'=> ProductController::class
// ]);

// Route::get('/', function () {

    //     $productUrl = route('product.view',['lang'=> 'en', 'id' => 1]);
    //     dd($productUrl);

    //     return view('welcome');
    // });


// Route::get('{lang}/product/{id}', function(string $lang, string $id){

// })->name('product.view');