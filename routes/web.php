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

Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');
Route::post('/employees/store', [EmployeeController::class, 'store'])->name('employees.store');
Route::get('/employees/{id}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
Route::put('/employees/{id}', [EmployeeController::class, 'update'])->name('employees.update');
Route::get('/api/v1/employees', [EmployeeController::class, 'getEmployees'])->name('api.employees.index');
Route::delete('/employees/{id}', [EmployeeController::class, 'destroy'])->name('employees.destroy');

Route::get('/positions', [PositionController::class, 'index'])->name('positions.index');
Route::get('/positions/create', [PositionController::class, 'create'])->name('positions.create');
Route::post('/positions/store', [PositionController::class, 'store'])->name('positions.store');
Route::get('/positions/{id}/edit', [PositionController::class, 'edit'])->name('positions.edit');
Route::put('/positions/{id}', [PositionController::class, 'update'])->name('positions.update');
Route::get('/api/v1/positions', [PositionController::class, 'getEmployees'])->name('api.positions.index');
Route::delete('/positions/{id}', [PositionController::class, 'destroy'])->name('positions.destroy');
