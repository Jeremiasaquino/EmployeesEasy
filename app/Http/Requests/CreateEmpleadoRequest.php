<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateEmpleadoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
             // Reglas de validación aquí
             'nombre' => 'required|string',
             'apellidos' => 'required|string',
             'fecha_nacimiento' => 'required|date',
             'genero' => 'required|in:Femenino,Masculino,Otro',
             'edad' => 'required|integer',
             'nacionalidad' => 'required|string',
             'estado_civil' => 'required|in:Soltero,Casado,Divorciado,Viudo',
             'tipo_identificacion' => 'required|in:Cedula,Pasaporte',
             'numero_identificacion' => 'required|string|unique:empleados|regex:/^\d+$/',
             'numero_seguro_social' => 'required|string|unique:empleados|regex:/^\d+$/',
             'numero_telefono' => 'required|string|unique:empleados|regex:/^\d+$/',
             'email' => 'required|email|unique:empleados',
             'posicione_id' => 'required|exists:posiciones,id',
             'departamento_id' => 'required|exists:departamentos,id',
             'horario_id' => 'required|exists:horarios,id',
             'estado' => 'required|in:activo,inactivo,suspendido,vacaciones,en_licencia,terminado',
             'image' => 'nullable|string',
             'calle' => 'required|string',
             'numero_calle' => 'required|numeric',
             'provincia' => 'required|string',
             'municipio' => 'required|string',
             'sector' => 'required|string',
             'localidad' => 'required|string',
             'edificio' => 'required|string',
             'numero_apartamento' => 'required|numeric',
             'referencia_ubicacion' => 'required|string',
             'nombre_banco' => 'required|string',
             'numero_cuenta_bancaria' => 'required|numeric||regex:/^\d+$/',
             'tipo_cuenta' => 'required|in:cuenta_corriente,cuenta_ahorros',
             'nombre_contacto' => 'required|string',
             'telefono_contacto' => 'required|string',
             'direccion_contacto' => 'required|string',
             'fecha_contrato' => 'required|date',
             'finalizacion_contrato' => 'required|date',
             'tipo_contrato' => 'required|',
             'tipo_salario' => 'required|',
             'salario'=> 'required|',
             'curriculum_vitae' => 'nullable|string',
             'cedula_identidad' => 'nullable|string',
             'seguro_social' => 'nullable|string',
             'titulos_certificados' => 'nullable|string',
             'otros_documentos' => 'nullable|string',
             'nombre_empresa_anterior',
             'cargo_anterior',
             'fecha_inicio_trabajo_anterior',
             'fecha_salida_trabajo_anterior',
             'motivo_salida',
             'telefono_empresa_anterior',
        ];
    }
}
