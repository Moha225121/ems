<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Models\Equipment;

use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Language Switcher
|--------------------------------------------------------------------------
*/
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'ar'])) {
        Session::put('locale', $locale);
    }
    return redirect()->back();
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes (Admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard', [
            'availableCount'  => Equipment::where('status', 'available')->count(),
            'reservedCount'   => Equipment::where('status', 'reserved')->count(),
            'checkedOutCount' => Equipment::where('status', 'checked_out')->count(),
        ]);
    })->name('dashboard');

    // Equipment CRUD
    Route::resource('equipment', EquipmentController::class);

    // Reservation
    Route::get('/reservations', [ReservationController::class, 'index'])
        ->name('reservations.index');
    Route::get('/reservations/{reservation}', [ReservationController::class, 'show'])
        ->name('reservations.show');

    Route::post('/equipment/{equipment}/reserve', [ReservationController::class, 'store'])
        ->name('equipment.reserve');

    Route::post('/reservations/{reservation}/cancel', [ReservationController::class, 'cancel'])
        ->name('reservations.cancel');

    // Transactions (Check In / Out)
    Route::post('/equipment/{equipment}/check-out', [TransactionController::class, 'checkOut'])
        ->name('equipment.checkOut');

    Route::post('/equipment/{equipment}/check-in', [TransactionController::class, 'checkIn'])
        ->name('equipment.checkIn');

    // Reports
    Route::get('/reports/usage', [ReportController::class, 'usageForm'])
        ->name('reports.usageForm');

    Route::get('/reports/usage/result', [ReportController::class, 'usageResult'])
        ->name('reports.usageResult');
});

/*
|--------------------------------------------------------------------------
| Authentication Routes (Laravel Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
