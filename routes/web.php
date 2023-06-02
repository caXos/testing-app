<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;

use Inertia\Inertia;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;
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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['middleware' => 'auth:sanctum'], function() {
    //------------------------------------------------------------------------------------------------------------------------------
    //Dashboard
    //------------------------------------------------------------------------------------------------------------------------------
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //------------------------------------------------------------------------------------------------------------------------------
    //Tasks
    //------------------------------------------------------------------------------------------------------------------------------
    //Index
    Route::get('tasks', [TaskController::class, 'index'])->name('tasks');
    //Create
    Route::get('tasks/add', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('tasks/add', [TaskController::class, 'store'])->name('tasks.store');
    //Edit
    Route::get('tasks/edit/{id}', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::post('tasks/edit/{id}', [TaskController::class, 'update'])->name('tasks.update');
    //Deactivate
    Route::delete('tasks/deactivate/{id}', [TaskController::class, 'deactivate'])->name('tasks.deactivate');
    //Destroy
    Route::delete('tasks/destroy/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');
}); 

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
