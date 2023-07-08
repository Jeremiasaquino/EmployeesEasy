<?php

namespace App\Models;

use App\Models\Empleado;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InformacionDirecion extends Model
{
    use HasFactory;

    protected $table = 'informacion_direcion';

    protected $fillable = [
        'calle',
        'numero_calle',
        'provincia',
        'municipio',
        'sector',
        'localidad',
        'edificio',
        'numero_apartamento',
        'referencia_ubicacion',
    ];


    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }
}
