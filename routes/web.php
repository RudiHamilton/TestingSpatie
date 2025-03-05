<?php

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::group(['middleware'=> ['role:super-admin|admin']], function () {

    Route::get('permissions/{permissionid}/delete',[PermissionController::class,'destroy']);
    Route::resource('permissions',PermissionController::class);
    
    Route::get('roles/{roleid}/delete',[RoleController::class,'destroy']);
    // ->middleware('permission:delete role');
    Route::resource('roles',RoleController::class);
    Route::get('roles/{roleid}/addpermission',[RoleController::class,'addPermissionToRole']);
    Route::put('roles/{roleid}/addpermission',[RoleController::class,'givePermissionToRole']);
    
    Route::get('users/{userid}/delete',[UserController::class,'destroy']);
    Route::resource('users',UserController::class);
});





Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
