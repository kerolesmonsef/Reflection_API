<?php

use App\Controllers\PostController;
use App\Controllers\UserController;
use App\Route;

Route::get('index.php', [UserController::class, "index"]);

Route::get('post-index', [PostController::class, "index"]);

Route::get('users', [UserController::class, "index"]);
Route::get('user', [UserController::class, "show"]);

Route::get('welcome', function () {
    echo "this is welcome";
});

Route::post("post_post", [PostController::class, 'store']);

if (!in_array($_GET['action_url'], Route::$validRouts)) {
    die("404 Page Not Found");
}

