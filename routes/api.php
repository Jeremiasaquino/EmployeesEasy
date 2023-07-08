<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\Api\HorarioController;
use App\Http\Controllers\Api\PosicionController;
use App\Http\Controllers\Api\DepartamentoController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
// Ruta para iniciar sesión
Route::post('/login', [LoginController::class, 'login'])->name('login');


// Rutas protegidas por el middleware de autenticación 'auth:sanctum'
//Route::middleware('auth:sanctum')->group(function () {

    // Ruta para cerrar sesión
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


    // Ruta para obtener los datos del usuario autenticado
    Route::prefix('usuarios')->group(function () {
        Route::get('/profile', [UserController::class, 'obtenerDatosUsuarioAutenticado']);
        Route::get('/', [UserController::class, 'index']);
       
    });


    // Rutas relacionadas con los empleados
    Route::prefix('empleados')->group(function () {
        // Obtener todos los empleados
        Route::get('/', [EmpleadoController::class, 'index']);
        // Crear un nuevo empleado
        Route::post('/', [EmpleadoController::class, 'store']);
        // Obtener los detalles de un empleado específico
        Route::get('/{id}', [EmpleadoController::class, 'show']);
        // Actualizar un empleado específico
        Route::put('/{id}', [EmpleadoController::class, 'update']);
        // Eliminar un empleado específico
        Route::delete('/{id}', [EmpleadoController::class, 'destroy']);
        // Ruta para obtener el departamento de un empleado
       // Route::get('/{employeeId}/departamentos', [EmpleadoController::class, 'getDepartment']);
        // Ruta para obtener el cargo de un empleado
      //  Route::get('/{employeeId}/cargo', [EmpleadoController::class, 'getPosition']);
    });

    // Rutas relacionadas con los departamentos
    Route::prefix('departamentos')->group(function () {
        // Obtener todos los departamentos
        Route::get('/', [DepartamentoController::class, 'index']);
        // Crear un nuevo departamento
        Route::post('/', [DepartamentoController::class, 'store']);
        // Obtener los detalles de un departamento específico
        Route::get('/{id}', [DepartamentoController::class, 'show']);
        // Actualizar un departamento específico
        Route::put('/{id}', [DepartamentoController::class, 'update']);
        // Eliminar un departamento específico
        Route::delete('/{id}', [DepartamentoController::class, 'destroy']);
        // Ruta para obtener los empleados de un departamento
     //   Route::get('/{departmentId}/empleados', [DepartamentoController::class, 'getEmployees']);
    });

    // Rutas relacionadas con los cargos
    Route::prefix('cargo')->group(function () {
        // Obtener todos los cargos
        Route::get('/', [PosicionController::class, 'index']);
        // Crear un nuevo cargo
        Route::post('/', [PosicionController::class, 'store']);
        // Obtener los detalles de un cargo específico
        Route::get('/{id}', [PosicionController::class, 'show']);
        // Actualizar un cargo específico
        Route::put('/{id}', [PosicioneController::class, 'update']);
        // Eliminar un cargo específico
        Route::delete('/{id}', [PosicionController::class, 'destroy']);
        // Ruta para obtener los empleados de un cargo
        Route::get('/{positionId}/empleados', [PosicionController::class, 'getEmployees']);
    });

    // Rutas relacionadas con los horarios
    Route::prefix('horarios')->group(function () {
        // Obtener todos los horarios
        Route::get('/', [HorarioController::class, 'index']);
        // Crear un nuevo horario
        Route::post('/', [HorarioController::class, 'store']);
        // Obtener los detalles de un horario específico
        Route::get('/{id}', [HorarioController::class, 'show']);
        // Actualizar un horario específico
        Route::put('/{id}', [HorarioController::class, 'update']);
        // Eliminar un horario específico
        Route::delete('/{id}', [HorarioController::class, 'destroy']);
        // Ruta para obtener los empleados de una hora
        Route::get('/{horarioId}/empleados', [HorarioController::class, 'getEmployees']);
    });
//});
