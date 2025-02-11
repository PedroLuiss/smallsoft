<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_apellido',
        'tipo_documento',
        'numero_documento',
        'email',
        'direccion',
        'telefono',
        'deuda',
        'estado'
    ];

    public static function deudaTotal() : float {
        return self::where('estado', true)->sum('deuda');
    }
}
