<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\InventarisController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/run-migrations', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        return 'Migrations run successfully! Log: <pre>' . \Illuminate\Support\Facades\Artisan::output() . '</pre>';
    } catch (\Exception $e) {
        return 'Migration failed: ' . $e->getMessage();
    }
});

Route::get('/db-test', function () {
    try {
        \Illuminate\Support\Facades\DB::connection()->getPdo();
        return 'Database connection is successful! Database name: ' . \Illuminate\Support\Facades\DB::connection()->getDatabaseName();
    } catch (\Exception $e) {
        return 'Database connection failed: ' . $e->getMessage();
    }
});

Route::get('/db-check', function () {
    try {
        $driver = \Illuminate\Support\Facades\DB::connection()->getDriverName();
        $status = 'Connected successfully!';
    } catch (\Exception $e) {
        $driver = 'Unknown (Connection failed)';
        $status = 'Connection failed: ' . $e->getMessage();
    }

    return [
        'default_connection' => config('database.default'),
        'driver' => $driver,
        'status' => $status,
        'database' => config('database.connections.mysql.database'),
        'host' => config('database.connections.mysql.host'),
    ];
});

Route::get('/health-check', function () {
    return [
        'app' => config('app.name'),
        'env' => config('app.env'),
        'db' => \Illuminate\Support\Facades\DB::connection()->getPdo() ? 'connected' : 'failed',
        'session_driver' => config('session.driver'),
        'cache_driver' => config('cache.default'),
    ];
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('transaksi', TransaksiController::class);
    Route::resource('inventaris', InventarisController::class);
});

require __DIR__.'/auth.php';