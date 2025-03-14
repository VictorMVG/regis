<?php

use App\Http\Controllers\Configuracion\Catalogos\StatusController;
use App\Http\Controllers\Configuracion\Usuarios\Catalogos\CompanyController;
use App\Http\Controllers\Configuracion\Usuarios\Catalogos\HeadquarterController;
use App\Http\Controllers\Configuracion\Usuarios\Catalogos\PermissionController;
use App\Http\Controllers\Configuracion\Usuarios\Catalogos\RoleController;
use App\Http\Controllers\Configuracion\Usuarios\UserController;
use App\Http\Controllers\Visitas\Visita\VisitController;
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
    Route::resource('sedes', HeadquarterController::class)->parameters(['sedes' => 'headquarter'])->names('headquarters');
    Route::resource('usuarios', UserController::class)->parameters(['usuarios' => 'user'])->names('users');
    Route::resource('permisos', PermissionController::class)->parameters(['permisos' => 'permission'])->names('permissions');
    Route::resource('roles', RoleController::class)->parameters(['roles' => 'role'])->names('roles');
    Route::resource('visitas', VisitController::class)->parameters(['visitas' => 'visit'])->names('visits');
});
