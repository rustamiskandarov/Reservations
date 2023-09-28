<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
Route::get('/locale/{lang}', [\App\Http\Controllers\LanguageController::class, 'switchLang']);


Route::get('/clear-cache', function() {
    $configCache = Artisan::call('config:cache');
    $clearCache = Artisan::call('cache:clear');
    return redirect()->back();
});
