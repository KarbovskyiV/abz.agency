<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PositionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/login', [LoginController::class, 'index']);
Route::post('/login', [LoginController::class, 'login']);

Route::prefix('employees')->name('employees.')->group(function () {
    Route::get('/', [EmployeeController::class, 'index'])->name('index');
    Route::get('/create', [EmployeeController::class, 'create'])->name('create');
    Route::post('/store', [EmployeeController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [EmployeeController::class, 'edit'])->name('edit');
    Route::put('/{id}', [EmployeeController::class, 'update'])->name('update');
    Route::delete('/{id}', [EmployeeController::class, 'destroy'])->name('destroy');
});
Route::get('/api/v1/employees', [EmployeeController::class, 'getEmployees'])->name('api.employees.index');

Route::prefix('positions')->name('positions.')->group(function () {
    Route::get('/', [PositionController::class, 'index'])->name('index');
    Route::get('/create', [PositionController::class, 'create'])->name('create');
    Route::post('/store', [PositionController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [PositionController::class, 'edit'])->name('edit');
    Route::put('/{id}', [PositionController::class, 'update'])->name('update');
    Route::delete('/{id}', [PositionController::class, 'destroy'])->name('destroy');
});
Route::get('/api/v1/positions', [PositionController::class, 'getEmployees'])->name('api.positions.index');
