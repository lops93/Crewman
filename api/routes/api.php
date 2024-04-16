<?php

use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\AssignmentRoleController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\EmploymentController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\LocationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('employees', EmployeeController::class);
Route::resource('employments', EmploymentController::class);
Route::resource('employers', EmployerController::class);
Route::resource('assignments', AssignmentController::class);
Route::resource('assignments/roles', AssignmentRoleController::class);
Route::resource('locations', LocationController::class);
Route::resource('leaves', LeaveController::class);

Route::get('/employee/last', [EmployeeController::class, 'getLastEmployee']);
