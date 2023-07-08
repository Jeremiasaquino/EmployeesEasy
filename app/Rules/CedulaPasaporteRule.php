<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CedulaPasaporteRule implements Rule
{
    public function passes($attribute, $value)
    {
        $tipoIdentificacion = request()->input('tipo_identificacion');

        if ($tipoIdentificacion === 'Cedula') {
            return preg_match('/^\d{11}$/', $value);
        } elseif ($tipoIdentificacion === 'Pasaporte') {
            return preg_match('/^[A-Z0-9]{6,9}$/', $value);
        }

        return false;
    }

    public function message()
    {
        $tipoIdentificacion = request()->input('tipo_identificacion');

        if ($tipoIdentificacion === 'Cedula') {
            return 'El número de cédula debe tener 11 dígitos.';
        } elseif ($tipoIdentificacion === 'Pasaporte') {
            return 'El número de pasaporte debe tener entre 6 y 9 caracteres alfanuméricos en mayúscula.';
        }

        return 'El número de identificación es inválido.';
    }
}
