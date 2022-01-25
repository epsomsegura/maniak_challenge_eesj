<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController as AC;
use App\Http\Controllers\HomeController as HC;
use App\Http\Controllers\UserController as UC;
use App\Http\Controllers\CategoryController as CC;
use App\Http\Controllers\BookController as BC;
use App\Http\Controllers\LibraryController as LC;


Route::group(["prefix"=>"/"],function(){
    Route::get("/",function(){return redirect("/login");});
    Route::get("/login", [AC::class,'loginView'])->name("login");
    Route::post("/login", [AC::class,'login']);
    Route::get("/logout", [AC::class,'logout'])->middleware('auth');
});


Route::group(["prefix"=>"/home","middleware"=>["auth"]],function(){
    Route::get("/",[HC::class,'homeView']);
});


Route::group(["prefix"=>"/users","middleware"=>["auth"]],function(){
    Route::get("/",[UC::class,'index']);
    Route::post("/",[UC::class,'save']);
    Route::put("/",[UC::class,'edit']);
    Route::delete("/",[UC::class,'delete']);
    Route::patch("/",[UC::class,'status']);
});

Route::group(["prefix"=>"/categories","middleware"=>["auth"]],function(){
    Route::get("/",[CC::class,'index']);
    Route::post("/",[CC::class,'save']);
    Route::put("/",[CC::class,'edit']);
    Route::delete("/",[CC::class,'delete']);
});

Route::group(["prefix"=>"/books","middleware"=>["auth"]],function(){
    Route::get("/",[BC::class,'index']);
    Route::post("/",[BC::class,'save']);
    Route::put("/",[BC::class,'edit']);
    Route::delete("/",[BC::class,'delete']);
});

Route::group(["prefix"=>"/library","middleware"=>["auth"]],function(){
    Route::get("/",[LC::class,'index']);
    Route::post("/",[LC::class,'borrow']);
    Route::patch("/",[LC::class,'return']);
});
