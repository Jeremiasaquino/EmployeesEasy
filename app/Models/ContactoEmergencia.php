<?php

namespace App\Models;

use App\Models\Empleado;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactoEmergencia extends Model
{
    use HasFactory;

    protected $table = 'contacto_emergencia';

    protected $fillable = [
        'nombre_contacto',
        'telefono_contacto',
        'direccion_contacto',
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }
}
