<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Supervisor\DashboardController;
use App\Http\Controllers\Web\Supervisor\LineWebController;
use App\Http\Controllers\Web\Supervisor\ToolWebController;
use App\Http\Controllers\Web\Supervisor\EmployeeWebController;
use App\Http\Controllers\Web\Supervisor\AssignmentWebController;
use App\Http\Controllers\Web\Supervisor\AuditWebController;
use App\Http\Controllers\Web\Supervisor\LoginWebController;

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
    return view('welcome');
});


Route::get('/login', [LoginWebController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginWebController::class, 'login']);
Route::post('/logout', [LoginWebController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:supervisor'])->prefix('supervisor')->name('supervisor.')->group(function () {
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');


Route::get('/lines', [LineWebController::class, 'index'])->name('lines.index');
Route::get('/lines/create', [LineWebController::class, 'create'])->name('lines.create');
Route::post('/lines', [LineWebController::class, 'store'])->name('lines.store');
Route::get('/lines/{line}/edit', [LineWebController::class, 'edit'])->name('lines.edit');
Route::put('/lines/{line}', [LineWebController::class, 'update'])->name('lines.update');
Route::delete('/lines/{line}', [LineWebController::class, 'destroy'])->name('lines.destroy');


Route::get('/tools', [ToolWebController::class, 'index'])->name('tools.index');
Route::get('/tools/create', [ToolWebController::class, 'create'])->name('tools.create');
Route::post('/tools', [ToolWebController::class, 'store'])->name('tools.store');
Route::get('/tools/{tool}/edit', [ToolWebController::class, 'edit'])->name('tools.edit');
Route::put('/tools/{tool}', [ToolWebController::class, 'update'])->name('tools.update');
Route::delete('/tools/{tool}', [ToolWebController::class, 'destroy'])->name('tools.destroy');


Route::get('/employees', [EmployeeWebController::class, 'index'])->name('employees.index');
Route::get('/employees/create', [EmployeeWebController::class, 'create'])->name('employees.create');
Route::post('/employees', [EmployeeWebController::class, 'store'])->name('employees.store');
Route::get('/employees/{employee}/edit', [EmployeeWebController::class, 'edit'])->name('employees.edit');
Route::put('/employees/{employee}', [EmployeeWebController::class, 'update'])->name('employees.update');
Route::delete('/employees/{employee}', [EmployeeWebController::class, 'destroy'])->name('employees.destroy');


Route::get('/assignments', [AssignmentWebController::class, 'index'])->name('assignments.index');
Route::get('/assignments/create', [AssignmentWebController::class, 'create'])->name('assignments.create');
Route::post('/assignments', [AssignmentWebController::class, 'store'])->name('assignments.store');
Route::get('/assignments/{assignment}/edit', [AssignmentWebController::class, 'edit'])->name('assignments.edit');
Route::put('/assignments/{assignment}', [AssignmentWebController::class, 'update'])->name('assignments.update');
Route::delete('/assignments/{assignment}', [AssignmentWebController::class, 'destroy'])->name('assignments.destroy');


Route::get('/audits', [AuditWebController::class, 'index'])->name('audits.index');
});