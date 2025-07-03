<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\ThemeLogController;


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
    Route::post('/log-theme-switch', [ThemeLogController::class, 'logSwitch']);
});

Route::post('/toggle-maintenance', [MaintenanceController::class, 'toggle'])->name('toggle.maintenance');
Route::post('/log-theme-event', [ThemeLogController::class, 'logEvent']);

require __DIR__ . '/auth.php';
