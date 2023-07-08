<?php

namespace App\Models;

use App\Models\Empleado;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Departamentos extends Model
{
    use HasFactory;
    protected $table = 'departamentos';
    protected $fillable = ['name'];

    public function empleado()
    {
        return $this->hasMany(Empleado::class);
    }
}
