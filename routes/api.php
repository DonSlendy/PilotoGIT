<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TodoController;
use App\Http\Controllers\TareasController;
use App\Http\Controllers\GeminiController;

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

//Route::post('/gemini/ask', [GeminiController::class, 'ask']);
Route::post('/recibir-ingredientes', [TareasController::class, 'recibirIngredientes']);