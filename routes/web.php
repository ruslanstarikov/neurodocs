<?php

use App\Http\Controllers\DomainController;
use App\Http\Controllers\DomainKnowledgeSourceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('domains', DomainController::class);
Route::get('domains/{domain}/manage', [DomainController::class, 'manage'])->name('domains.manage');

// Knowledge Sources nested under domains
Route::prefix('domains/{domain}')->name('domains.')->group(function () {
    Route::resource('knowledge-sources', DomainKnowledgeSourceController::class)->parameters([
        'knowledge-sources' => 'knowledgeSource'
    ]);
});
