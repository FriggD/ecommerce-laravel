<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class HomeController extends Controller
{
    public function index(){
        // if(!View::exists('home.example')){
        //     dump("View does not exist");
        // }
        // return View::make('home.index');
        // return view('home.index',[
        //     'name' => "Frigg",
        //     'surname' => "D"
        // ]);
        return view('home.index')
        ->with('name', 'Frigg')
        ->with('surname', 'D')
        ;
    }
}
