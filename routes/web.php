<?php

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;

$user = User::query()->where('email', 'ardian@oriona.com')->first();
Auth::login($user);

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::resource('projects', ProjectController::class);
    Route::post('projects/{project}/members/{user}/role', [ProjectController::class, 'assignRole'])->name('projects.members.role');
    Route::post('projects/{project}/invite', [ProjectController::class, 'invite'])->name('projects.invite');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
