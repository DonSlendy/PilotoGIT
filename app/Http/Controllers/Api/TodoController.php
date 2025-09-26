<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'message' => 'Lista de tareas obtenida exitosamente',
            'data' => [
                ['id' => 1, 'title' => 'Tarea de ejemplo', 'completed' => false],
                ['id' => 2, 'title' => 'Otra tarea', 'completed' => true]
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        return response()->json([
            'message' => 'Tarea creada exitosamente',
            'data' => [
                'id' => rand(1, 1000),
                'title' => $request->title,
                'description' => $request->description,
                'completed' => false,
                'created_at' => now()
            ]
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json([
            'message' => 'Tarea obtenida exitosamente',
            'data' => [
                'id' => $id,
                'title' => 'Tarea específica',
                'description' => 'Descripción de la tarea',
                'completed' => false
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'completed' => 'sometimes|boolean'
        ]);

        return response()->json([
            'message' => 'Tarea actualizada exitosamente',
            'data' => [
                'id' => $id,
                'title' => $request->title ?? 'Tarea actualizada',
                'description' => $request->description,
                'completed' => $request->completed ?? false,
                'updated_at' => now()
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return response()->json([
            'message' => 'Tarea eliminada exitosamente',
            'data' => [
                'id' => $id,
                'deleted_at' => now()
            ]
        ]);
    }
}
