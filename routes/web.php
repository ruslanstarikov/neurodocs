<?php

use App\Http\Controllers\DomainController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('domains', DomainController::class);
Route::get('domains/{domain}/manage', [DomainController::class, 'manage'])->name('domains.manage');
