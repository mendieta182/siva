<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('lang/{locale}', function ($locale) {
    // Available languages
    $availableLangs = [
        'en' => 'en',
        'es' => 'es',
    ];
    if (array_key_exists($locale, $availableLangs)) {
        session()->put('locale', $locale);
    }
    return redirect()->back();


})->name('lang');

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('/');

// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified',
// ])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
//     Route::get('/users', function () {
//         return Inertia::render('Users/Index');
//     })->name('users.index');
//     Route::get('/roles', function () {
//         return Inertia::render('Roles/Index');
//     })->name('roles.index');
// });

Route::prefix('admin')->name('admin.')
    ->middleware(['auth:sanctum','verified'])
    ->group(function (){
    // Route::get('dashboard',[AdminDashboardController::class,'index'])->name('dashboard.index');

    // Route::resource('admins',AdminController::class)
    //     ->parameters(['admins'=>'user'])
    //     ->only(['index','update']);

    Route::patch('users/activate/{user}',[UserController::class,'activate'])->name('users.activate');
    Route::patch('users/inactivate/{user}',[UserController::class,'inactivate'])->name('users.inactivate');
    Route::resource('users',UserController::class)
        ->except(['create','show','edit']);

    // Route::resource('permissions',PermissionController::class)
    //     ->except(['create','show','edit']);

    // Route::resource('roles',RoleController::class)
    //     ->except(['create','show','edit']);

    Route::get('/roles', function () {
        return Inertia::render('Roles/Index');
    })->name('roles.index');
});
