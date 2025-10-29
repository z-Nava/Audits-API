<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Supervisor\DashboardController;
use App\Http\Controllers\Web\Supervisor\LineWebController;
use App\Http\Controllers\Web\Supervisor\ToolWebController;
use App\Http\Controllers\Web\Supervisor\EmployeeWebController;
use App\Http\Controllers\Web\Supervisor\AssignmentWebController;
use App\Http\Controllers\Web\Supervisor\AuditWebController;


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

Route::middleware(['auth', 'role:supervisor'])->prefix('supervisor')->name('supervisor.')->group(function () {
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');


Route::get('/lines', [LineWebController::class, 'index'])->name('lines.index');
Route::get('/tools', [ToolWebController::class, 'index'])->name('tools.index');
Route::get('/employees', [EmployeeWebController::class, 'index'])->name('employees.index');
Route::get('/assignments', [AssignmentWebController::class, 'index'])->name('assignments.index');
Route::get('/audits', [AuditWebController::class, 'index'])->name('audits.index');
});