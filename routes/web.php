<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\LandController;
use App\Http\Controllers\LandShareSaleController;
use App\Http\Controllers\LandSharePaymentController;
use App\Http\Controllers\LandRegistrationController;
use App\Http\Controllers\RajukApprovalController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {

    Route::resource('users', UserController::class);
    // Other routes...
    Route::resource('companies', CompanyController::class);
    Route::resource('branches', BranchController::class);
    Route::resource('projects', ProjectController::class);
    Route::resource('clients', ClientController::class);

    Route::resource('lands', LandController::class);
    Route::resource('land-share-sales', LandShareSaleController::class);
    
    Route::resource('land-share-payments', LandSharePaymentController::class);
    Route::get('land-share-payments/{landSharePayment}/print', [LandSharePaymentController::class, 'print'])->name('land-share-payments.print');

    Route::resource( 'land-registrations', LandRegistrationController::class);
    Route::get( 'land-registrations/{landRegistration}/print', [LandRegistrationController::class, 'print'])->name('land-registrations.print');

    Route::resource('rajuk-approvals', RajukApprovalController::class)->names('rajuk-approvals');
 
    Route::get('rajuk-approvals/{rajukApproval}/print', [RajukApprovalController::class, 'print'])->name('rajuk-approvals.print');

    Route::resource('rajuk-approvals', RajukApprovalController::class)->names('rajuk-approvals'); 


});







require __DIR__.'/auth.php';
