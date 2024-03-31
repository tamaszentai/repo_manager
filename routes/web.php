<?php

use App\Http\Controllers\RepoController;
use App\Http\Controllers\SetupController;
use App\Http\Middleware\EnsureDontCompleteSetupTwice;
use App\Http\Middleware\EnsureSetupHasDone;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/repos');
});

Route::resource('setup', SetupController::class)->only(['index', 'store', 'edit'])->middleware(EnsureDontCompleteSetupTwice::class);

Route::resource('repos', RepoController::class)->only(['index'])->middleware(EnsureSetupHasDone::class);
