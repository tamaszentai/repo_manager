<?php

use App\Http\Controllers\RepoController;
use App\Http\Controllers\SetupController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/repos');
});

Route::resource('setup', SetupController::class)->only(['index', 'store']);

Route::resource('repos', RepoController::class)->only(['index']);
