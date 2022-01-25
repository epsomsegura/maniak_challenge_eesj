<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController as AC;

Route::group(["prefix"=>"/"],function(){
    Route::post("/login", [AC::class,'login']);
    Route::post ("/refreshToken", [AC::class,'JWTRefresh']);
    Route::get("/me", [AC::class,'JWTMe'])->middleware('jwt.verify');
    Route::get("/logout", [AC::class,'logout'])->middleware('jwt.verify');
});

Route::group(["prefix"=>"/home","middleware"=>["jwt.verify"]],function(){
    Route::get("/",[HC::class,'homeView']);
});


Route::group(["prefix"=>"/users","middleware"=>["jwt.verify"]],function(){
    Route::get("/",[UC::class,'index']);
    Route::post("/",[UC::class,'save']);
    Route::put("/",[UC::class,'edit']);
    Route::delete("/",[UC::class,'delete']);
    Route::patch("/",[UC::class,'status']);
});

Route::group(["prefix"=>"/categories","middleware"=>["jwt.verify"]],function(){
    Route::get("/",[CC::class,'index']);
    Route::post("/",[CC::class,'save']);
    Route::put("/",[CC::class,'edit']);
    Route::delete("/",[CC::class,'delete']);
});

Route::group(["prefix"=>"/books","middleware"=>["jwt.verify"]],function(){
    Route::get("/",[BC::class,'index']);
    Route::post("/",[BC::class,'save']);
    Route::put("/",[BC::class,'edit']);
    Route::delete("/",[BC::class,'delete']);
});

Route::group(["prefix"=>"/library","middleware"=>["jwt.verify"]],function(){
    Route::get("/",[LC::class,'index']);
    Route::post("/",[LC::class,'borrow']);
    Route::patch("/",[LC::class,'return']);
});

