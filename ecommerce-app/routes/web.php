<?php
use App\Http\Controllers\CarController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // $person =[
    //     'name'=> 'Frigg',
    //     'email'=> 'frigg@email.com',
    // ];
    // dd => dump and die
    // dd($person);
    // dump($person);

    // $aboutPageUrl = '/about';

    // $aboutPageUrl = route('about');
    $productUrl = route('product.view',['lang'=> 'en', 'id' => 1]);
    dd($productUrl);

    return view('welcome');
});

Route::get('{lang}/product/{id}', function(string $lang, string $id){

})->name('product.view');

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

Route::controller(CarController::class)->group(function(){
    Route::get('/car', 'index');
});






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

