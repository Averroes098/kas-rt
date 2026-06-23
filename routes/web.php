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
        return response()->json([
            'status' => 'success',
            'message' => 'Database connection is successful!',
            'database' => \Illuminate\Support\Facades\DB::connection()->getDatabaseName(),
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Database connection failed!',
            'error_detail' => $e->getMessage(),
            'host' => config('database.connections.mysql.host'),
            'port' => config('database.connections.mysql.port'),
            'database_config' => config('database.connections.mysql.database'),
        ], 500);
    }
});

Route::get('/env-check', function () {
    return response()->json([
        'DB_CONNECTION' => env('DB_CONNECTION'),
        'DB_HOST' => env('DB_HOST'),
        'DB_PORT' => env('DB_PORT'),
        'DB_DATABASE' => env('DB_DATABASE'),
        'DB_USERNAME' => env('DB_USERNAME'),

        'config_connection' => config('database.default'),
        'config_host' => config('database.connections.mysql.host'),
        'config_port' => config('database.connections.mysql.port'),
        'config_database' => config('database.connections.mysql.database'),
        
        'MYSQLHOST' => env('MYSQLHOST') ? 'EXISTS' : 'NOT FOUND',
        'MYSQLPORT' => env('MYSQLPORT') ? 'EXISTS' : 'NOT FOUND',
        'MYSQLDATABASE' => env('MYSQLDATABASE') ? 'EXISTS' : 'NOT FOUND',
        'MYSQLUSER' => env('MYSQLUSER') ? 'EXISTS' : 'NOT FOUND',
        'MYSQL_HOST' => env('MYSQL_HOST') ? 'EXISTS' : 'NOT FOUND',
        'MYSQL_PORT' => env('MYSQL_PORT') ? 'EXISTS' : 'NOT FOUND',
        'MYSQL_DATABASE' => env('MYSQL_DATABASE') ? 'EXISTS' : 'NOT FOUND',
        'MYSQL_USER' => env('MYSQL_USER') ? 'EXISTS' : 'NOT FOUND',
    ]);
});

Route::get('/env-full-check', function () {
    return response()->json([
        'DB_CONNECTION' => getenv('DB_CONNECTION'),
        'DB_HOST' => getenv('DB_HOST'),
        'DB_PORT' => getenv('DB_PORT'),
        'DB_DATABASE' => getenv('DB_DATABASE'),
        'DB_USERNAME' => getenv('DB_USERNAME'),
        'DB_PASSWORD_SET' => getenv('DB_PASSWORD') ? true : false,
    ]);
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

Route::get('/check-users', function () {
    return [
        'count' => \App\Models\User::count(),
        'users' => \App\Models\User::select('id','name','email','created_at')->get(),
    ];
});

Route::get('/create-admin', function () {
    $user = \App\Models\User::updateOrCreate(
        [
            'email' => 'admin1@gmail.com'
        ],
        [
            'name' => 'Administrator',
            'password' => \Illuminate\Support\Facades\Hash::make('admin12345')
        ]
    );

    return [
        'status' => 'success',
        'id' => $user->id,
        'email' => $user->email
    ];
});

Route::get('/reset-admin', function () {
    $user = \App\Models\User::where('email', 'admin1@gmail.com')->first();

    if (!$user) {
        return ['status' => 'user not found'];
    }

    $user->password = \Illuminate\Support\Facades\Hash::make('admin12345');
    $user->save();

    return [
        'status' => 'password reset',
        'email' => $user->email
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