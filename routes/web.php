<?php

use App\Http\Controllers\Catalogos\UnitColorController;
use App\Http\Controllers\Catalogos\UnitTypeController;
use App\Http\Controllers\Configuracion\Catalogos\StatusController;
use App\Http\Controllers\Configuracion\Usuarios\Catalogos\CompanyController;
use App\Http\Controllers\Configuracion\Usuarios\Catalogos\HeadquarterController;
use App\Http\Controllers\Configuracion\Usuarios\Catalogos\PermissionController;
use App\Http\Controllers\Configuracion\Usuarios\Catalogos\RoleController;
use App\Http\Controllers\Configuracion\Usuarios\UserController;
use App\Http\Controllers\Visitas\Visita\VisitController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware([

    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'check.status',

])->group(function () {

    Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');

    // Configuraciones
    // Route::resource('estatus', StatusController::class)->parameters(['estatus' => 'status'])->names('statuses');
    // Route::resource('empresas', CompanyController::class)->parameters(['empresas' => 'company'])->names('companies');
    // Route::resource('sedes', HeadquarterController::class)->parameters(['sedes' => 'headquarter'])->names('headquarters');
    // Route::resource('usuarios', UserController::class)->parameters(['usuarios' => 'user'])->names('users');
    // Route::resource('permisos', PermissionController::class)->parameters(['permisos' => 'permission'])->names('permissions');
    // Route::resource('roles', RoleController::class)->parameters(['roles' => 'role'])->names('roles');
    // Route::resource('colores-de-unidad', UnitColorController::class)->parameters(['colores-de-unidad' => 'unitColor'])->names('unit-colors');
    // Route::resource('tipos-de-unidad', UnitTypeController::class)->parameters(['tipos-de-unidad' => 'unitType'])->names('unit-types');
    // Route::resource('visitas', VisitController::class)->parameters(['visitas' => 'visit'])->names('visits');
    // Route::patch('/visits/{visit}/exit-time', [VisitController::class, 'updateExitTime'])->name('visits.updateExitTime');


        // ------------------------------
    // Rutas para Estatus
    // ------------------------------
    Route::get('estatus', [StatusController::class, 'index'])->name('statuses.index')->middleware('role:SUPER USUARIO');
    Route::get('estatus/create', [StatusController::class, 'create'])->name('statuses.create')->middleware('role:SUPER USUARIO');
    Route::post('estatus', [StatusController::class, 'store'])->name('statuses.store')->middleware('role:SUPER USUARIO');
    Route::get('estatus/{status}', [StatusController::class, 'show'])->name('statuses.show')->middleware('role:SUPER USUARIO');
    Route::get('estatus/{status}/edit', [StatusController::class, 'edit'])->name('statuses.edit')->middleware('role:SUPER USUARIO');
    Route::put('estatus/{status}', [StatusController::class, 'update'])->name('statuses.update')->middleware('role:SUPER USUARIO');
    Route::delete('estatus/{status}', [StatusController::class, 'destroy'])->name('statuses.destroy')->middleware('role:SUPER USUARIO');

    // ------------------------------
    // Rutas para Empresas
    // ------------------------------
    Route::get('empresas', [CompanyController::class, 'index'])->name('companies.index')->middleware('role:SUPER USUARIO|ADMINISTRADOR GENERAL');
    Route::get('empresas/create', [CompanyController::class, 'create'])->name('companies.create')->middleware('role:SUPER USUARIO|ADMINISTRADOR GENERAL');
    Route::post('empresas', [CompanyController::class, 'store'])->name('companies.store')->middleware('role:SUPER USUARIO|ADMINISTRADOR GENERAL');
    Route::get('empresas/{company}', [CompanyController::class, 'show'])->name('companies.show')->middleware('role:SUPER USUARIO|ADMINISTRADOR GENERAL');
    Route::get('empresas/{company}/edit', [CompanyController::class, 'edit'])->name('companies.edit')->middleware('role:SUPER USUARIO|ADMINISTRADOR GENERAL');
    Route::put('empresas/{company}', [CompanyController::class, 'update'])->name('companies.update')->middleware('role:SUPER USUARIO|ADMINISTRADOR GENERAL');
    Route::delete('empresas/{company}', [CompanyController::class, 'destroy'])->name('companies.destroy')->middleware('role:SUPER USUARIO|ADMINISTRADOR GENERAL');

    // ------------------------------
    // Rutas para Sedes
    // ------------------------------
    Route::get('sedes', [HeadquarterController::class, 'index'])->name('headquarters.index')->middleware('role:SUPER USUARIO|ADMINISTRADOR GENERAL|ADMINISTRADOR DE SEDE');
    Route::get('sedes/create', [HeadquarterController::class, 'create'])->name('headquarters.create')->middleware('role:SUPER USUARIO|ADMINISTRADOR GENERAL|ADMINISTRADOR DE SEDE');
    Route::post('sedes', [HeadquarterController::class, 'store'])->name('headquarters.store')->middleware('role:SUPER USUARIO|ADMINISTRADOR GENERAL|ADMINISTRADOR DE SEDE');
    Route::get('sedes/{headquarter}', [HeadquarterController::class, 'show'])->name('headquarters.show')->middleware('role:SUPER USUARIO|ADMINISTRADOR GENERAL');
    Route::get('sedes/{headquarter}/edit', [HeadquarterController::class, 'edit'])->name('headquarters.edit')->middleware('role:SUPER USUARIO|ADMINISTRADOR GENERAL|ADMINISTRADOR DE SEDE');
    Route::put('sedes/{headquarter}', [HeadquarterController::class, 'update'])->name('headquarters.update')->middleware('role:SUPER USUARIO|ADMINISTRADOR GENERAL|ADMINISTRADOR DE SEDE');
    Route::delete('sedes/{headquarter}', [HeadquarterController::class, 'destroy'])->name('headquarters.destroy')->middleware('role:SUPER USUARIO|ADMINISTRADOR GENERAL');

    // ------------------------------
    // Rutas para Usuarios
    // ------------------------------
    Route::get('usuarios', [UserController::class, 'index'])->name('users.index')->middleware('role:SUPER USUARIO|ADMINISTRADOR GENERAL|ADMINISTRADOR DE SEDE');
    Route::get('usuarios/create', [UserController::class, 'create'])->name('users.create')->middleware('role:SUPER USUARIO|ADMINISTRADOR GENERAL|ADMINISTRADOR DE SEDE');
    Route::post('usuarios', [UserController::class, 'store'])->name('users.store')->middleware('role:SUPER USUARIO|ADMINISTRADOR GENERAL|ADMINISTRADOR DE SEDE');
    Route::get('usuarios/{user}', [UserController::class, 'show'])->name('users.show')->middleware('role:SUPER USUARIO|ADMINISTRADOR GENERAL|ADMINISTRADOR DE SEDE');
    Route::get('usuarios/{user}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware('role:SUPER USUARIO|ADMINISTRADOR GENERAL|ADMINISTRADOR DE SEDE');
    Route::put('usuarios/{user}', [UserController::class, 'update'])->name('users.update')->middleware('role:SUPER USUARIO|ADMINISTRADOR GENERAL|ADMINISTRADOR DE SEDE');
    Route::delete('usuarios/{user}', [UserController::class, 'destroy'])->name('users.destroy')->middleware('role:SUPER USUARIO|ADMINISTRADOR GENERAL|ADMINISTRADOR DE SEDE');

    // ------------------------------
    // Rutas para Permisos
    // ------------------------------
    Route::get('permisos', [PermissionController::class, 'index'])->name('permissions.index')->middleware('role:SUPER USUARIO');
    Route::get('permisos/create', [PermissionController::class, 'create'])->name('permissions.create')->middleware('role:SUPER USUARIO');
    Route::post('permisos', [PermissionController::class, 'store'])->name('permissions.store')->middleware('role:SUPER USUARIO');
    Route::get('permisos/{permission}', [PermissionController::class, 'show'])->name('permissions.show')->middleware('role:SUPER USUARIO');
    Route::get('permisos/{permission}/edit', [PermissionController::class, 'edit'])->name('permissions.edit')->middleware('role:SUPER USUARIO');
    Route::put('permisos/{permission}', [PermissionController::class, 'update'])->name('permissions.update')->middleware('role:SUPER USUARIO');
    Route::delete('permisos/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy')->middleware('role:SUPER USUARIO');

    // ------------------------------
    // Rutas para Roles
    // ------------------------------
    Route::get('roles', [RoleController::class, 'index'])->name('roles.index')->middleware('role:SUPER USUARIO');
    Route::get('roles/create', [RoleController::class, 'create'])->name('roles.create')->middleware('role:SUPER USUARIO');
    Route::post('roles', [RoleController::class, 'store'])->name('roles.store')->middleware('role:SUPER USUARIO');
    Route::get('roles/{role}', [RoleController::class, 'show'])->name('roles.show')->middleware('role:SUPER USUARIO');
    Route::get('roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit')->middleware('role:SUPER USUARIO');
    Route::put('roles/{role}', [RoleController::class, 'update'])->name('roles.update')->middleware('role:SUPER USUARIO');
    Route::delete('roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy')->middleware('role:SUPER USUARIO');

    // ------------------------------
    // Rutas para Colores de Unidad
    // ------------------------------
    Route::get('colores-de-unidad', [UnitColorController::class, 'index'])->name('unit-colors.index')->middleware('role:SUPER USUARIO|ADMINISTRADOR GENERAL');
    Route::get('colores-de-unidad/create', [UnitColorController::class, 'create'])->name('unit-colors.create')->middleware('role:SUPER USUARIO|ADMINISTRADOR GENERAL');
    Route::post('colores-de-unidad', [UnitColorController::class, 'store'])->name('unit-colors.store')->middleware('role:SUPER USUARIO|ADMINISTRADOR GENERAL');
    Route::get('colores-de-unidad/{unitColor}', [UnitColorController::class, 'show'])->name('unit-colors.show')->middleware('role:SUPER USUARIO|ADMINISTRADOR GENERAL');
    Route::get('colores-de-unidad/{unitColor}/edit', [UnitColorController::class, 'edit'])->name('unit-colors.edit')->middleware('role:SUPER USUARIO|ADMINISTRADOR GENERAL');
    Route::put('colores-de-unidad/{unitColor}', [UnitColorController::class, 'update'])->name('unit-colors.update')->middleware('role:SUPER USUARIO|ADMINISTRADOR GENERAL');
    Route::delete('colores-de-unidad/{unitColor}', [UnitColorController::class, 'destroy'])->name('unit-colors.destroy')->middleware('role:SUPER USUARIO|ADMINISTRADOR GENERAL');

    // ------------------------------
    // Rutas para Tipos de Unidad
    // ------------------------------
    Route::get('tipos-de-unidad', [UnitTypeController::class, 'index'])->name('unit-types.index')->middleware('role:SUPER USUARIO|ADMINISTRADOR GENERAL');
    Route::get('tipos-de-unidad/create', [UnitTypeController::class, 'create'])->name('unit-types.create')->middleware('role:SUPER USUARIO|ADMINISTRADOR GENERAL');
    Route::post('tipos-de-unidad', [UnitTypeController::class, 'store'])->name('unit-types.store')->middleware('role:SUPER USUARIO|ADMINISTRADOR GENERAL');
    Route::get('tipos-de-unidad/{unitType}', [UnitTypeController::class, 'show'])->name('unit-types.show')->middleware('role:SUPER USUARIO|ADMINISTRADOR GENERAL');
    Route::get('tipos-de-unidad/{unitType}/edit', [UnitTypeController::class, 'edit'])->name('unit-types.edit')->middleware('role:SUPER USUARIO|ADMINISTRADOR GENERAL');
    Route::put('tipos-de-unidad/{unitType}', [UnitTypeController::class, 'update'])->name('unit-types.update')->middleware('role:SUPER USUARIO|ADMINISTRADOR GENERAL');
    Route::delete('tipos-de-unidad/{unitType}', [UnitTypeController::class, 'destroy'])->name('unit-types.destroy')->middleware('role:SUPER USUARIO|ADMINISTRADOR GENERAL');

    // ------------------------------
    // Rutas para Visitas
    // ------------------------------
    Route::get('visitas', [VisitController::class, 'index'])->name('visits.index')->middleware('role:SUPER USUARIO||ADMINISTRADOR GENERAL|ADMINISTRADOR DE SEDE');
    Route::get('visitas/create', [VisitController::class, 'create'])->name('visits.create')->middleware('role:SUPER USUARIO|ADMINISTRADOR GENERAL|GUARDIA');
    Route::post('visitas', [VisitController::class, 'store'])->name('visits.store')->middleware('role:SUPER USUARIO|ADMINISTRADOR GENERAL|GUARDIA');
    Route::get('visitas/{visit}', [VisitController::class, 'show'])->name('visits.show')->middleware('role:SUPER USUARIO|ADMINISTRADOR GENERAL|ADMINISTRADOR DE SEDE|GUARDIA');
    Route::get('visitas/{visit}/edit', [VisitController::class, 'edit'])->name('visits.edit')->middleware('role:SUPER USUARIO|ADMINISTRADOR GENERAL|ADMINISTRADOR DE SEDE');
    Route::put('visitas/{visit}', [VisitController::class, 'update'])->name('visits.update')->middleware('role:SUPER USUARIO|ADMINISTRADOR GENERAL|ADMINISTRADOR DE SEDE');
    Route::delete('visitas/{visit}', [VisitController::class, 'destroy'])->name('visits.destroy')->middleware('role:SUPER USUARIO|ADMINISTRADOR GENERAL');
    Route::patch('/visits/{visit}/exit-time', [VisitController::class, 'updateExitTime'])->name('visits.updateExitTime')->middleware('role:SUPER USUARIO|ADMINISTRADOR GENERAL|GUARDIA');
    Route::get('/visits/export', [VisitController::class, 'export'])->name('visits.export')->middleware('role:SUPER USUARIO|ADMINISTRADOR GENERAL|ADMINISTRADOR DE SEDE|GUARDIA');
    Route::get('/visits/export-filtered', [VisitController::class, 'exportFiltered'])->name('visits.exportFiltered');

});
