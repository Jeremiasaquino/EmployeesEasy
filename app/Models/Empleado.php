<?php

namespace App\Models;

use App\Models\ContactoEmergencia;
use App\Models\DocumentoRequirido;
use App\Models\InformacionLarabol;
use App\Models\InformacionBancaria;
use App\Models\InformacionDirecion;
use Illuminate\Database\Eloquent\Model;
use App\Models\HistorialEmpresaAnterior;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Empleado extends Model
{
    use HasFactory;

    protected $table = 'empleados';

    protected $fillable = [
        'nombre', 'apellidos', 'fecha_nacimiento', 'genero', 'edad', 'nacionalidad',
        'estado_civil', 'tipo_identificacion', 'numero_identificacion', 'numero_seguro_social',
        'numero_telefono', 'email', 'estado', 'image', 'posicione_id',
        'horario_id', 'departamento_id',
    ];

    public function posicione()
    {
        return $this->belongsTo(Posiciones::class);
    }

    public function horario()
    {
        return $this->belongsTo(Horarios::class);
    }

    public function departamento()
    {
        return $this->belongsTo(Departamentos::class);
    }


    public function informacionDirecion()
    {
        return $this->hasOne(InformacionDirecion::class);
    }

    public function informacionBancaria()
    {
        return $this->hasOne(InformacionBancaria::class);
    }

    public function contactoEmergencia()
    {
        return $this->hasOne(ContactoEmergencia::class);
    }

    public function informacionLarabol()
    {
        return $this->hasOne(InformacionLarabol::class);
    }

    public function documentoRequirido()
    {
        return $this->hasOne(DocumentoRequirido::class);
    }

    public function historialEmpresaAnterior()
    {
        return $this->hasOne(HistorialEmpresaAnterior::class);
    }
}
