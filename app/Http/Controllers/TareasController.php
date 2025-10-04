<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TareasModel;
use App\Services\GeminiService;
use Illuminate\Support\Facades\Log;

class TareasController extends Controller
{
    public function crearTarea(Request $request)
    {

        try {
            Log::info($request->all());

            $dataValidate = $request->validate([
                "nombre" => "required|string|max:100",
                "descrip" => "required|string|max:100",
                "estado" => "required|in:" . implode(',', TareasModel::getEstadosValidos()),
                "puntos" => "required|integer"
            ]);

            $tarea = TareasModel::create($dataValidate);
            return response()->json($tarea, 201);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['error' => 'Error al crear la tarea'], 500);
        }
    }

    public function listarTareas()
    {
        $tareas = TareasModel::all();
        return response()->json($tareas);
    }

    public function obtenerTarea($id)
    {
        $tarea = TareasModel::find($id);
        if (!$tarea) {
            return response()->json(['error' => 'Tarea no encontrada'], 404);
        }
        return response()->json($tarea);
    }

    public function actualizarTarea(Request $request, $id)
    {
        $tarea = TareasModel::find($id);
        if (!$tarea) {
            return response()->json(['error' => 'Tarea no encontrada'], 404);
        }

        $dataValidate = $request->validate([
            "nombre" => "sometimes|string|max:100",
            "descrip" => "sometimes|string|max:100",
            "estado" => "sometimes|in:" . implode(',', TareasModel::getEstadosValidos()),
            "puntos" => "sometimes|integer"
        ]);

        $tarea->update($dataValidate);
        return response()->json($tarea);
    }

    public function eliminarTarea($id)
    {
        $tarea = TareasModel::find($id);
        if (!$tarea) {
            return response()->json(['error' => 'Tarea no encontrada'], 404);
        }

        $tarea->delete();
        return response()->json(['message' => 'Tarea eliminada exitosamente']);
    }

    public function recibirIngredientes(Request $request)
    {
        $ingredientes = $request->validate([
            "ingredientes" => "required|array",
        ]);

        $geminiService = new GeminiService();
        $gemini = new GeminiController($geminiService);

        // Pasar solo el array de ingredientes, no todo el objeto validado
        $result = $gemini->ask($ingredientes['ingredientes']);

        if ($result->original == "NO\n") {
            return response()->json(['message' => 'No se encontraron recetas para los ingredientes proporcionados'], 404);
        } else {
            return response()->json($result);
        }
    }
}
