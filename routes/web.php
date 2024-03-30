<?php

use App\Http\Controllers\RepoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/repos');
});

Route::get('repos', [RepoController::class, 'index']);
