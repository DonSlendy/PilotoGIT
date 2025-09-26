<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TodoController;
use App\Http\Controllers\TareasController;

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

// Ruta de usuario (requiere autenticación - comentada temporalmente)
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Ruta de prueba para verificar que la API funciona
Route::get('/test', function () {
    return response()->json([
        'message' => 'API funcionando correctamente',
        'status' => 'success',
        'timestamp' => now()
    ]);
});

// Rutas para tareas
Route::post("/crear-tarea", [TareasController::class, "crearTarea"]);
Route::get("/tareas", [TareasController::class, "listarTareas"]);
Route::get("/tareas/{id}", [TareasController::class, "obtenerTarea"]);
Route::put("/tareas/{id}", [TareasController::class, "actualizarTarea"]);
Route::delete("/tareas/{id}", [TareasController::class, "eliminarTarea"]);

// Rutas para tareas usando el controlador
Route::apiResource('todos', TodoController::class);
