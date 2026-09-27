<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProjectController;

Route::get('/', function () {
    return view('welcome');
});

    Route::prefix('admin')->name('admin.')->group(function () {
            Route::resource('companies', CompanyController::class);
            Route::resource('branches', BranchController::class);
            Route::resource('projects', ProjectController::class);

    });


    