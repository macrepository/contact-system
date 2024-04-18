<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;

Route::middleware('auth')->group(function () {
    Route::get('/contacts', [ContactController::class, 'createList'])->name('contacts');
    Route::get('/contact/add', [ContactController::class, 'createAdd'])->name('addContact');
    Route::get('/contact/edit/{id}', [ContactController::class, 'createEdit'])->name('editContact');

    Route::post('/contact/add', [ContactController::class, 'add']);
    Route::patch('/contact/edit/{id}', [ContactController::class, 'update']);
    Route::delete('/contact/{id}', [ContactController::class, 'delete'])->name('deleteContact');
});
