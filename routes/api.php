<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', 'AuthController@register');

Route::post('login', 'AuthController@login');

Route::middleware('auth:api')->group(function () {

Route::resource('posts', 'PostController');
Route::get('posts/user/{id}','PostController@userPosts');
Route::post('change-password', 'AuthController@change_password');

});
