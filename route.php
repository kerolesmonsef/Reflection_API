<?php

use App\Controllers\HomeController;
use App\Controllers\ProfileController;
use App\Route;



Route::get('/', [HomeController::class, 'index']);
Route::get('/profile/{name}', [ProfileController::class, "profile"]);
Route::get('/profile/{name}/friends', [ProfileController::class, "show"]);
Route::get('/profile/{name}/friends/{limit}', [ProfileController::class, "limit"]);

//Route::get('post-index', [PostController::class, "index"]);

//Route::get('users', [UserController::class, "index"]);
//Route::get('user', [UserController::class, "show"]);

//Route::get('welcome', function () {
//    echo "this is welcome";
//});
//
//Route::post("post_post", [PostController::class, 'store']);

//if (!in_array($_GET['action_url'], Route::$validRouts)) {
//    die("404 Page Not Found");
//}

