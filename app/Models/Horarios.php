<?php

namespace App\Models;

use App\Models\Empleados;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Horarios extends Model
{
    use HasFactory;

    protected $table = 'horarios';

    protected $fillable = [
        'hora_entrada',
        'hora_salida',
        'dias_semana',
    ];

    protected $casts = [
        'dias_semana' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        // Convierte las horas de entrada y salida a objetos Carbon al guardar y cargar desde la base de datos
        static::saving(function (Horarios $horario) {
            $horario->hora_entrada = Carbon::createFromFormat('h:i A', trim($horario->hora_entrada));
            $horario->hora_salida = Carbon::createFromFormat('h:i A', trim($horario->hora_salida));
        });

        static::retrieved(function (Horarios $horario) {
            $horario->hora_entrada = Carbon::parse($horario->hora_entrada)->format('h:i A');
            $horario->hora_salida = Carbon::parse($horario->hora_salida)->format('h:i A');
        });
    }

    public function getHoraEntradaAttribute($value)
    {
        return Carbon::parse($value)->format('h:i A');
    }

    public function getHoraSalidaAttribute($value)
    {
        return Carbon::parse($value)->format('h:i A');
    }

    // Relaciones u otros métodos relacionados con el modelo Horario

    public function empleados()
    {
        return $this->hasMany(Empleados::class);
    }
}
