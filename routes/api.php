<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ContactController;

Route::middleware('auth')->group(function () {
    Route::get('/api/contacts', [ContactController::class, 'getContactList']);
});
