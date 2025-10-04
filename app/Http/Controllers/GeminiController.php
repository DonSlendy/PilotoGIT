<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GeminiService;

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
            . "El nombre de la receta deber ir separado por comas.";

        $result = $this->gemini->generateText($prompt);

        $recetas = $result['candidates'][0]['content']['parts'][0]['text'] ?? null;

        return response()->json($recetas);
    }
}
