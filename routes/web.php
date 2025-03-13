<?php

use App\Http\Controllers\Configuracion\Catalogos\StatusController;
use App\Http\Controllers\Configuracion\Usuarios\Catalogos\CompanyController;
use App\Http\Controllers\Configuracion\Usuarios\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([

    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',

])->group(function () {

    Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');

    // Configuraciones
    Route::resource('estatus', StatusController::class)->parameters(['estatus' => 'status'])->names('statuses');
    Route::resource('empresas', CompanyController::class)->parameters(['empresas' => 'company'])->names('companies');
    Route::resource('usuarios', UserController::class)->parameters(['usuarios' => 'user'])->names('users');
});
