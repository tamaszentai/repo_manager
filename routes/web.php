<?php

use App\Http\Controllers\RepoController;
use App\Http\Controllers\SetupController;
use App\Http\Middleware\EnsureDontCompleteSetupTwice;
use App\Http\Middleware\EnsureSetupHasDone;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LibraryController;

Route::get('/', function () {
    return redirect('/repos');
});

Route::resource('setup', SetupController::class)->only(['index', 'store', 'edit', 'update'])->middleware(EnsureDontCompleteSetupTwice::class);

Route::post('repos/next', [RepoController::class, 'next'])->name('repos.next')->middleware(EnsureSetupHasDone::class);
Route::resource('repos', RepoController::class)->only(['index'])->middleware(EnsureSetupHasDone::class);

Route::post('library/clone', [LibraryController::class, 'cloneRepo'])->name('cloneRepo');

Route::post('library/delete', [LibraryController::class, 'deleteRepo'])->name('deleteRepo');

Route::post('library/install', [LibraryController::class, 'installDependencies'])->name('installDependencies');

Route::post('library/remove', [LibraryController::class, 'removeDependencies'])->name('removeDependencies');
