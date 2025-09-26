<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TareasModel extends Model
{

    protected $table = 'tareas';
    protected $fillable = ['nombre', 'descrip', 'estado', 'puntos'];
    
    // Constantes para los valores del ENUM
    const ESTADO_COMPLETO = 'completado';
    const ESTADO_FALTANTE = 'pendiente';
    
    // Array con todos los valores válidos
    public static function getEstadosValidos()
    {
        return [
            self::ESTADO_COMPLETO,
            self::ESTADO_FALTANTE
        ];
    }
    
    // Scope para filtrar por estado
    public function scopeCompletas($query)
    {
        return $query->where('estado', self::ESTADO_COMPLETO);
    }
    
    public function scopeFaltantes($query)
    {
        return $query->where('estado', self::ESTADO_FALTANTE);
    }
}
