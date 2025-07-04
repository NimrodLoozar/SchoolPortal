<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AverageGradeController;
use App\Http\Controllers\ClassController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\MaintenanceController;
// use App\Http\Controllers\ThemeLogController;


Route::get('/dashboard', function () {
    $isMaintenanceMode = DB::table('settings')->where('key', 'maintenance_mode')->value('value') ?? false;
    return view('dashboard', compact('isMaintenanceMode'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        $isMaintenanceMode = DB::table('settings')->where('key', 'maintenance_mode')->value('value') ?? false;
        return view('dashboard', compact('isMaintenanceMode'));
    })->name('/');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Route::post('/log-theme-switch', [ThemeLogController::class, 'logSwitch']);

    // User Management Routes (Owner only)
    Route::resource('users', UserController::class);
    Route::patch('users/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('users.toggle-active');

    // Average Grades Routes (Owner only)
    Route::get('/average-grades', [AverageGradeController::class, 'index'])->name('grades.average');
    Route::get('/average-grades/{subject}', [AverageGradeController::class, 'show'])->name('grades.subject-details');

    // Class Management Routes (Owner only)
    Route::get('/classes', [ClassController::class, 'index'])->name('classes.index');
    Route::get('/classes/{class}', [ClassController::class, 'show'])->name('classes.show');
    Route::get('/classes/{class}/students/{student}', [ClassController::class, 'showStudent'])->name('classes.student');
});

Route::post('/toggle-maintenance', [MaintenanceController::class, 'toggle'])->name('toggle.maintenance');
// Route::post('/log-theme-event', [ThemeLogController::class, 'logEvent']);

require __DIR__ . '/auth.php';
