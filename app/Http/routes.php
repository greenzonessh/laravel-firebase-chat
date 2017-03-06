<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
use \Log;

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/home', 'HomeController@index');

Route::get('/image', function() {
    $imagedata = file_get_contents("https://placeimg.com/80/80/user");
    $base64 = base64_encode($imagedata);
    $img = sprintf("data:image/png;base64,%s", $base64);
    return "<img src='$img'/>";
    // dd($base64);
    Log::debug('image');
    Log::info($imagedata);
    Log::info($base64);
    return 'success';
    return $base64;
});