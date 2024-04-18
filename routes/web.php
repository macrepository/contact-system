<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

require __DIR__ . '/user.php';
require __DIR__ . '/contact.php';
require __DIR__ . '/api.php';