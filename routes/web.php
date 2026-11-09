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

use App\Http\Controllers\BuildingController;

use App\Http\Controllers\BuildingClientAssignmentController;

use App\Http\Controllers\ConstructionCostCategoryController;

use App\Http\Controllers\ConstructionCostController;




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

    Route::resource('buildings', BuildingController::class)->names('buildings');
    Route::get('buildings/{building}/print', [BuildingController::class, 'print'])->name('buildings.print');

    Route::resource('building-client-assignments', BuildingClientAssignmentController::class)->except(['show'])->names('building-client-assignments');
    Route::resource('construction-cost-categories', ConstructionCostCategoryController::class)->names('construction-cost-categories');
    Route::resource('construction-costs', ConstructionCostController::class)->names('construction-costs');
    Route::get('construction-costs/{constructionCost}/print',  [ConstructionCostController::class, 'print'])->name('construction-costs.print');

});


require __DIR__.'/auth.php';
