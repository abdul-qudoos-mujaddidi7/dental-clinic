<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BillExpenseController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CureController;
use App\Http\Controllers\CureCycleController;
use App\Http\Controllers\CurePaymentController;
use App\Http\Controllers\DentistController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExpenseCategoryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\OwnerPickupController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceGroupController;
use App\Http\Controllers\StageController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SystemSettingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

Route::post('/login', [AuthController::class, 'login']);

// Group all routes that need authentication
Route::middleware('auth:sanctum')->group(function () {
    // Authenticated user route
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Resource routes that require authentication
    Route::apiResource('/expenseCategories', ExpenseCategoryController::class);
    Route::apiResource('/billExpenses', BillExpenseController::class);
    Route::apiResource('/ownerPickups', OwnerPickupController::class);
    Route::apiResource('/products', ProductController::class);
    Route::apiResource('/expenses', ExpenseController::class);
    Route::apiResource('/payments', PaymentController::class);
    Route::apiResource('/suppliers', SupplierController::class);
    Route::apiResource('/dentists', DentistController::class);
    Route::apiResource('/owners', OwnerController::class);
    Route::apiResource('/users', UserController::class);
    Route::apiResource('/patients', PatientController::class);
    Route::apiResource('/appointments', AppointmentController::class);
    Route::apiResource('/categories', CategoryController::class);
    Route::apiResource('/stages', StageController::class);
    Route::apiResource('/leads', LeadController::class);
    Route::apiResource('/services', ServiceController::class);
    Route::apiResource('/serviceGroups', ServiceGroupController::class);

    // System Settings
    Route::post('/systemSettings/updateSettings/{systemSetting}', [SystemSettingController::class, 'updateSetting']);
    Route::apiResource('/systemSettings', SystemSettingController::class);

    // Cure-related routes
    Route::apiResource('/cures', CureController::class);
    Route::apiResource('/curePayments', CurePaymentController::class);
    Route::apiResource('/cureCycles', CureCycleController::class);

    // Logout route (requires authentication)
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('/role_permissions', RolePermissionController::class);
    
});



