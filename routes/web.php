<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthWebController;
use App\Http\Controllers\Web\Supervisor\DashboardController;
use App\Http\Controllers\Web\Supervisor\AssignmentsController as SupAssignmentsController;
use App\Http\Controllers\Web\Supervisor\AuditsController as SupAuditsController;

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

// Login web (sesión)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthWebController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthWebController::class, 'login'])->name('login.post');
});

// Panel (requiere sesión + rol)
Route::middleware(['auth', 'role:supervisor,admin'])->group(function () {

    Route::post('/logout', [AuthWebController::class, 'logout'])->name('logout');

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Asignaciones
    Route::get('/assignments', [SupAssignmentsController::class, 'index'])->name('assignments.index');
    Route::get('/assignments/{assignment}', [SupAssignmentsController::class, 'show'])->name('assignments.show');
    Route::patch('/assignments/{assignment}/status', [SupAssignmentsController::class, 'updateStatus'])->name('assignments.status');

    // Auditorías (revisión)
    Route::get('/audits', [SupAuditsController::class, 'index'])->name('audits.index');
    Route::get('/audits/{audit}', [SupAuditsController::class, 'show'])->name('audits.show');
    Route::post('/audits/{audit}/review', [SupAuditsController::class, 'review'])->name('audits.review');
    Route::post('/audits/{audit}/reopen', [SupAuditsController::class, 'reopen'])->name('audits.reopen');
});
