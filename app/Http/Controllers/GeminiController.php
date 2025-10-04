<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GeminiService;
use Illuminate\Support\Facades\Log;

class GeminiController extends Controller
{
    protected $gemini;

    public function __construct(GeminiService $gemini)
    {
        $this->gemini = $gemini;
    }

    public function ask($ingredientes)
    {
        // Verificar si $ingredientes es un array y extraer los ingredientes correctamente
        if (is_array($ingredientes) && isset($ingredientes['ingredientes'])) {
            $ingredientesList = $ingredientes['ingredientes'];
        } else {
            $ingredientesList = $ingredientes;
        }

        // Asegurar que sea un array plano
        if (!is_array($ingredientesList)) {
            $ingredientesList = [$ingredientesList];
        }

        $prompt = "Genera solo el nombre de tres recetas de cocina basado en los siguientes ingredientes: " . implode(", ", $ingredientesList)
            . "El nombre de la receta deber ir separado por comas, si detectas un 'ingrediente' que no sea comida, devuelve un sencillo 'NO'.";

        $result = $this->gemini->generateText($prompt);

        $recetas = $result['candidates'][0]['content']['parts'][0]['text'] ?? null;

        return response()->json($recetas);
    }

    public function crearReceta(Request $request)
    {
        $receta = $request->validate([
            "receta" => "required|string|max:100",
            "ingredientes" => "required|array",
        ]);

        $prompt = "Genera una receta de cocina basada en esta idea: " . $receta['receta']
            . "Los ingredientes de la receta son: " . implode(", ", $receta['ingredientes'])
            . "La receta debe tener un mínimo de 10 pasos, debe ser sencilla para que todo el mundo pueda hacerla"
            . "Los pasos de la receta deben ir separados por un punto y coma al igual que el título de la receta"
            . "No coloques un saludo al principio de la receta, solo el contenido de la receta";

        $result = $this->gemini->generateText($prompt);

        $recetas = $result['candidates'][0]['content']['parts'][0]['text'] ?? null;

        Log::info($recetas);
        $arrayRecetas = explode(";", $recetas);
        return response()->json($arrayRecetas);
    }
}
