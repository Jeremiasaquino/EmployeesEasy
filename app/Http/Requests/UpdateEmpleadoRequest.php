<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmpleadoRequest extends FormRequest
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
            'fecha_nacimiento' => 'required|date_format:d-m-Y',
            'genero' => 'required|in:Femenino,Masculino,Otro',
            'edad' => 'required|integer',
            'nacionalidad' => 'required|string',
            'estado_civil' => 'required|in:Soltero,Casado,Divorciado,Viudo',
            'tipo_identificacion' => 'required|in:Cedula,Pasaporte',
            'numero_identificacion' => 'sometimes|required|string|unique:empleados,numero_identificacion,' . $this->route('id'),
            'numero_seguro_social' => 'sometimes|string|unique:empleados,numero_seguro_social,' . $this->route('id'),
            'numero_telefono' => 'sometimes|required|string|unique:empleados,numero_telefono,' . $this->route('id'),
            'email' =>  'sometimes|required|email|unique:empleados,email,' . $this->route('id'),
            'estado' => 'required|in:Activo,Inactivo,Suspendido,Vacaciones,Licencia,Terminado',
            'foto' => 'nullable|string',
            'foto_id' => 'nullable|string',

            'posicione_id' => 'required|exists:posiciones,id',
            'departamento_id' => 'required|exists:departamentos,id',
            'horario_id' => 'required|exists:horarios,id',
            
            'calle' => 'required|string',
            'provincia' => 'required|string',
            'municipio' => 'required|string',
            'sector' => 'required|string',
            'numero_residencia' => 'required|string',
            'referencia_ubicacion' => 'nullable|string',

            'nombre_banco' => 'nullable|string',
            'numero_cuenta_bancaria' => 'sometimes|nullable|numeric|unique:informacion_bancaria,numero_cuenta_bancaria,' . $this->route('id'),
            'tipo_cuenta' => 'nullable|in:Cuenta Corriente, Cuenta Ahorro|',

            'nombre_contacto1' => 'nullable|string',
            'telefono_contacto1' => 'sometimes|string|unique:contacto_emergencia,telefono_contacto1,' . $this->route('id'),
            'direccion_contacto1' => 'nullable|string',
            'nombre_contacto2' => 'nullable|string',
            'telefono_contacto2' => 'sometimes||string|unique:contacto_emergencia,telefono_contacto2,'. $this->route('id'),
            'direccion_contacto2' => 'nullable|string',
            
            'fecha_contrato' => 'required|date_format:d-m-Y',
            'finalizacion_contrato' => 'required|date_format:d-m-Y',
            'tipo_contrato' => 'required|',
            'tipo_salario' => 'required|',
            'salario'=> 'required|',

            'curriculum_vitae' => 'nullable|string',
            'cedula_identidad' => 'nullable|string',
            'seguro_social' => 'nullable|string',
            'titulos_certificados' => 'nullable|string',
            'otros_documentos' => 'nullable|string',

            'nombre_empresa_anterior' => 'nullable|string',
             'cargo_anterior' => 'nullable|string',
             'fecha_inicio_trabajo_anterior' => 'nullable|date_format:d-m-Y',
             'fecha_salida_trabajo_anterior' => 'nullable|date_format:d-m-Y',
             'motivo_salida' => 'nullable|string',

        ];
    }
}


// 'nombre' => 'required|string',
// 'apellidos' => 'required|string',
// 'fecha_nacimiento' => 'required|date',
// 'genero' => 'required|in:Femenino,Masculino,Otro',
// 'edad' => 'required|integer',
// 'nacionalidad' => 'required|string',
// 'estado_civil' => 'required|in:Soltero,Casado,Divorciado,Viudo',
// 'tipo_identificacion' => 'required|in:Cedula,Pasaporte',
// 'numero_identificacion' => 'sometimes|required|string|unique:empleados,numero_identificacion,' . $this->route('id') . '|regex:/^\d+$/',
// 'numero_seguro_social' => 'sometimes|required|string|unique:empleados,numero_seguro_social,' . $this->route('id') . '|regex:/^\d+$/',
// 'numero_telefono' => 'sometimes|required|string|unique:empleados,numero_telefono,' . $this->route('id') . '|regex:/^\d+$/',
// 'email' => 'sometimes|required|email|unique:empleados,email,' . $this->route('id'),
// 'posicione_id' => 'required|exists:posiciones,id',
// 'departamento_id' => 'required|exists:departamentos,id',
// 'horario_id' => 'required|exists:horarios,id',
// 'estado' => 'required|in:activo,inactivo,suspendido,vacaciones,en_licencia,terminado',
// 'image' => 'nullable|string',
// 'calle' => 'required|string',
// 'numero_calle' => 'required|numeric',
// 'provincia' => 'required|string',
// 'municipio' => 'required|string',
// 'sector' => 'required|string',
// 'localidad' => 'required|string',
// 'edificio' => 'required|string',
// 'numero_apartamento' => 'required|numeric',
// 'referencia_ubicacion' => 'required|string',
// 'nombre_banco' => 'required|string',
// 'numero_cuenta_bancaria' => 'required|numeric|regex:/^\d+$/',
// 'tipo_cuenta' => 'required|in:cuenta_corriente,cuenta_ahorros',
// 'nombre_contacto' => 'required|string',
// 'telefono_contacto' => 'required|numeric',
// 'direccion_contacto' => 'required|string',
// 'fecha_contrato' => 'required|date',
// 'finalizacion_contrato' => 'required|date',
// 'tipo_contrato' => 'required|',
// 'tipo_salario' => 'required|',
// 'salario'=> 'required|numeric',
// 'curriculum_vitae' => 'nullable|string',
// 'cedula_identidad' => 'nullable|string',
// 'seguro_social' => 'nullable|string',
// 'titulos_certificados' => 'nullable|string',
// 'otros_documentos' => 'nullable|string',
// 'nombre_empresa_anterior',
// 'cargo_anterior',
// 'fecha_inicio_trabajo_anterior'  => 'nullable|date',
// 'fecha_salida_trabajo_anterior' => 'nullable|date',
// 'motivo_salida' => 'nullable|string',
// 'telefono_empresa_anterior' => 'nullable|numeric|regex:/^\d+$/',