<?php

namespace App\Models;

use App\Models\Empleado;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Posiciones extends Model
{
    use HasFactory;
    protected $table = 'posiciones';
    protected $fillable = ['posicion'];

    public function empleado()
    {
        return $this->hasMany(Empleado::class);
    }
}
