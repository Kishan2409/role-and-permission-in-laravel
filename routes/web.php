<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
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


Route::redirect('/', 'login');

// Route::get('/', function () {
//     if (Auth::check()) {
//         return redirect()->route('dashboard');
//     }
//     return view('auth.login');
// });

Route::get('/dashboard', function () {

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    //profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit')->middleware('permission:profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/checkemail_edit', [UserController::class, 'checkemail_edit']);
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy')->middleware('permission:profile.destroy');

    //role
    Route::get('/role', [RoleController::class, 'index'])->name('role')->middleware('permission:role.show');
    Route::get('/role/create', [RoleController::class, 'create'])->name('role.create')->middleware('permission:role.create');
    Route::post('/role/create', [RoleController::class, 'store']);
    Route::get('/role/edit/{id}', [RoleController::class, 'edit'])->name('role.edit')->middleware('permission:role.edit');
    Route::post('/role/edit/{id}', [RoleController::class, 'update']);
    Route::get('/role/show/{id}', [RoleController::class, 'show'])->name('role.show')->middleware('permission:role.show');
    Route::get('/role/delete/{id}', [RoleController::class, 'destroy'])->name('role.delete')->middleware('permission:role.delete');
    Route::post('/checkslug_add', [RoleController::class, 'checkslug_add']);
    Route::post('/checkslug_edit', [RoleController::class, 'checkslug_edit']);

    //users
    Route::get('/users', [UserController::class, 'index'])->name('users')->middleware('permission:users.show');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create')->middleware('permission:users.create');
    Route::post('/users/create', [UserController::class, 'store']);
    Route::get('/users/edit/{id}', [UserController::class, 'edit'])->name('users.edit')->middleware('permission:users.edit');
    Route::post('/users/edit/{id}', [UserController::class, 'update']);
    Route::get('/users/show/{id}', [UserController::class, 'show'])->name('users.show')->middleware('permission:users.show');
    Route::get('/users/delete/{id}', [UserController::class, 'destroy'])->name('users.delete')->middleware('permission:users.delete');
    Route::post('/checkemail_add', [UserController::class, 'checkemail_add']);
    Route::post('/checkemail_edit', [UserController::class, 'checkemail_edit']);
});

require __DIR__ . '/auth.php';
