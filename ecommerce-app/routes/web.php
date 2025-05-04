<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // $person =[
    //     'name'=> 'Frigg',
    //     'email'=> 'frigg@email.com',
    // ];
    // dd => dump and die
    // dd($person);
    // dump($person);

    return view('welcome');
});

// [
// EQUIVALENTES
Route::view(uri:'/about', view:'about');

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