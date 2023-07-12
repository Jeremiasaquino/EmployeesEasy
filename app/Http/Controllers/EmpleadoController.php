<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\CreateEmpleadoRequest;
use App\Http\Requests\UpdateEmpleadoRequest;

class EmpleadoController extends Controller
{

    public function index()
    {
        $empleados = Empleado::with('informacionDirecion', 'informacionBancaria', 'contactoEmergencia', 'informacionLarabol', 'documentoRequirido', 'historialEmpresaAnterior')->get();

        if ($empleados->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'No hay empleados registrados'], 404);
        }

        return response()->json(['success' => true, 'message' => 'Empleados registrados', 'empleados' => $empleados]);
    }

    public function store(CreateEmpleadoRequest $request)
    {

        // Validar los datos del formulario
        $validator = Validator::make($request->all(), $request->rules(), $request->messages());

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $empleado = $this->createEmpleado($request);
            return response()->json([
                'success' => true,
                'message' => 'Empleado creado exitosamente',
                'data' => $empleado
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el empleado',
                'errors' => [$e->getMessage()]
            ], 500);
        }
    }

    private function createEmpleado(Request $request)
    {
        $fecha_nacimiento = Carbon::createFromFormat('d-m-Y', $request->input('fecha_nacimiento'))->format('Y-m-d');

        $empleado = Empleado::create([
            // Campos del empleado
            'nombre' => $request->input('nombre'),
            'apellidos' => $request->input('apellidos'),
            'fecha_nacimiento' => $fecha_nacimiento,
            'edad' => $request->input('edad'),
            'genero' => $request->input('genero'),
            'nacionalidad' => $request->input('nacionalidad'),
            'estado_civil' => $request->input('estado_civil'),
            'tipo_identificacion' => $request->input('tipo_identificacion'),
            'numero_identificacion' => $request->input('numero_identificacion'),
            'numero_seguro_social' => $request->input('numero_seguro_social'),
            'numero_telefono' => $request->input('numero_telefono'),
            'email' => $request->input('email'),
            'posicione_id' => $request->input('posicione_id'),
            'departamento_id' => $request->input('departamento_id'),
            'horario_id' => $request->input('horario_id'),
            'estado' => $request->input('estado'),
            'foto' => $request->input('foto'),
            'foto_id' => $request->input('foto_id'),
        ]);

            $this->createInformacionDireccion($empleado, $request);
            $this->createInformacionBancaria($empleado, $request);
            $this->createContactoEmergencia($empleado, $request);
            $this->createInformacionLarabol($empleado, $request);
            $this->createDocumentoRequirido($empleado, $request);
            $this->createHistorialEmpresaAnterior($empleado, $request);

        return $empleado;
    }

    private function createInformacionDireccion(Empleado $empleado, Request $request)
    {
        $empleado->informacionDirecion()->create([
            // Campos de InformacionDireccion
            'calle' => $request->input('calle'),
            'provincia' => $request->input('provincia'),
            'municipio' => $request->input('municipio'),
            'sector' => $request->input('sector'),
            'numero_residencia' => $request->input('numero_residencia'),
            'referencia_ubicacion' => $request->input('referencia_ubicacion'),
        ]);
    }

    private function createInformacionBancaria(Empleado $empleado, Request $request)
    {
        $empleado->informacionBancaria()->create([
            // Campos de InformacionBancaria
            'nombre_banco' => $request->input('nombre_banco'),
            'numero_cuenta_bancaria' => $request->input('numero_cuenta_bancaria'),
            'tipo_cuenta' => $request->input('tipo_cuenta'),
        ]);
    }

    private function createContactoEmergencia(Empleado $empleado, Request $request)
    {
        $empleado->contactoEmergencia()->create([
            // Campos de ContactoEmergencia
            'nombre_contacto1' => $request->input('nombre_contacto1'),
            'telefono_contacto1' => $request->input('telefono_contacto1'),
            'direccion_contacto1' => $request->input('direccion_contacto1'),
            'nombre_contacto2' => $request->input('nombre_contacto2'),
            'telefono_contacto2' => $request->input('telefono_contacto2'),
            'direccion_contacto2' => $request->input('direccion_contacto2'),
        ]);
    }

    private function createInformacionLarabol(Empleado $empleado, Request $request)
    {
        $fecha_contrato = Carbon::createFromFormat('d-m-Y', $request->input('fecha_contrato'))->format('Y-m-d');
        $finalizacion_contrato = Carbon::createFromFormat('d-m-Y', $request->input('finalizacion_contrato'))->format('Y-m-d');

        $empleado->informacionLarabol()->create([
            // Campos de InformacionLarabol
            'fecha_contrato' => $fecha_contrato,
            'finalizacion_contrato' => $finalizacion_contrato,
            'tipo_contrato' => $request->input('tipo_contrato'),
            'tipo_salario' => $request->input('tipo_salario'),
            'salario' => $request->input('salario'),
        ]);
    }

    private function createDocumentoRequirido(Empleado $empleado, Request $request)
    {
        $empleado->documentoRequirido()->create([
            // Campos de DocumentoRequirido
            'curriculum_vitae' => $request->input('curriculum_vitae'),
            'cedula_identidad' => $request->input('cedula_identidad'),
            'seguro_social' => $request->input('seguro_social'),
            'titulos_certificados' => $request->input('titulos_certificados'),
            'otros_documentos' => $request->input('otros_documentos'),
        ]);
    }

    private function createHistorialEmpresaAnterior(Empleado $empleado, Request $request)
    {
        if($request->has('fecha_inicio_trabajo_anterior')) {
            $fecha_inicio_trabajo_anterior = Carbon::createFromFormat('d-m-Y', $request->input('fecha_inicio_trabajo_anterior'))->format('Y-m-d');
        }else {
            $fecha_inicio_trabajo_anterior = null;
        }
        
        if ($request->has('fecha_salida_trabajo_anterior')) {
            $fecha_salida_trabajo_anterior = Carbon::createFromFormat('d-m-Y', $request->input('fecha_salida_trabajo_anterior'))->format('Y-m-d');
        } else {
            $fecha_salida_trabajo_anterior = null;
        }

        $empleado->historialEmpresaAnterior()->create([
            // Campos de HistorialEmpresaAnterior
            'nombre_empresa_anterior' => $request->input('nombre_empresa_anterior'),
            'cargo_anterior' => $request->input('cargo_anterior'),
            'fecha_inicio_trabajo_anterior' => $fecha_inicio_trabajo_anterior,
            'fecha_salida_trabajo_anterior' => $fecha_salida_trabajo_anterior,
            'motivo_salida' => $request->input('motivo_salida'),
        ]);
    }
    

    public function show($id)
    {
        $empleado = Empleado::with('informacionDirecion', 'informacionBancaria', 'contactoEmergencia', 'informacionLarabol', 'documentoRequirido', 'historialEmpresaAnterior')->find($id);

        if (!$empleado) {
            return response()->json(['success' => false, 'message' => 'No se encontró un empleado con el ID especificado'], 404);
        }

        return response()->json(['success' => true, 'message' => 'Empleado encontrado', 'empleado' => $empleado]);
    }


    public function update(UpdateEmpleadoRequest $request, $id)
    {
        // Buscar el empleado por su ID
        $empleado = Empleado::find($id);

        if (!$empleado) {
            return response()->json(['success' => false, 'message' => 'No se encontró un empleado con el ID especificado'], 404);
        }

        // Validar los datos del formulario
        $validator = Validator::make($request->all(), $request->rules(), $request->messages());


        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $this->updateEmpleado($empleado, $request);

            return response()->json([
                'success' => true,
                'message' => 'Empleado actualizado exitosamente',
                'data' => $empleado
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el empleado',
                'errors' => [$e->getMessage()]
            ], 500);
        }
    }

    private function updateEmpleado(Empleado $empleado, Request $request)
    {
        $fecha_nacimiento = Carbon::createFromFormat('d-m-Y', $request->input('fecha_nacimiento'))->format('Y-m-d');

        $empleado->update([
            // Campos del empleado para actualizar
            'nombre' => $request->input('nombre'),
            'apellidos' => $request->input('apellidos'),
            'fecha_nacimiento' => $fecha_nacimiento,
            'genero' => $request->input('genero'),
            'edad' => $request->input('edad'),
            'nacionalidad' => $request->input('nacionalidad'),
            'estado_civil' => $request->input('estado_civil'),
            'tipo_identificacion' => $request->input('tipo_identificacion'),
            'numero_identificacion' => $request->input('numero_identificacion'),
            'numero_seguro_social' => $request->input('numero_seguro_social'),
            'numero_telefono' => $request->input('numero_telefono'),
            'email' => $request->input('email'),
            'posicione_id' => $request->input('posicione_id'),
            'departamento_id' => $request->input('departamento_id'),
            'horario_id' => $request->input('horario_id'),
            'estado' => $request->input('estado'),
            'foto' => $request->input('foto'),
            'foto_id' => $request->input('foto_id'),
        ]);

        $this->updateInformacionDireccion($empleado, $request);
        $this->updateInformacionBancaria($empleado, $request);
        $this->updateContactoEmergencia($empleado, $request);
        $this->updateInformacionLarabol($empleado, $request);
        $this->updateDocumentoRequirido($empleado, $request);
        $this->updateHistorialEmpresaAnterior($empleado, $request);
    }

    private function updateInformacionDireccion(Empleado $empleado, Request $request)
    {
        $empleado->informacionDirecion()->update([
            // Campos de InformacionDireccion para actualizar
            'calle' => $request->input('calle'),
            'provincia' => $request->input('provincia'),
            'municipio' => $request->input('municipio'),
            'sector' => $request->input('sector'),
            'numero_residencia' => $request->input('numero_residencia'),
            'referencia_ubicacion' => $request->input('referencia_ubicacion'),
        ]);
    }

    private function updateInformacionBancaria(Empleado $empleado, Request $request)
    {
        $empleado->informacionBancaria()->update([
            // Campos de InformacionBancaria para actualizar
            'nombre_banco' => $request->input('nombre_banco'),
            'numero_cuenta_bancaria' => $request->input('numero_cuenta_bancaria'),
            'tipo_cuenta' => $request->input('tipo_cuenta'),
        ]);
    }

    private function updateContactoEmergencia(Empleado $empleado, Request $request)
    {
        $empleado->contactoEmergencia()->update([
            // Campos de ContactoEmergencia para actualizar
            'nombre_contacto1' => $request->input('nombre_contacto1'),
            'telefono_contacto1' => $request->input('telefono_contacto1'),
            'direccion_contacto1' => $request->input('direccion_contacto1'),
            'nombre_contacto2' => $request->input('nombre_contacto2'),
            'telefono_contacto2' => $request->input('telefono_contacto2'),
            'direccion_contacto2' => $request->input('direccion_contacto2'),
        ]);
    }

    private function updateInformacionLarabol(Empleado $empleado, Request $request)
    {
        $fecha_contrato = Carbon::createFromFormat('d-m-Y', $request->input('fecha_contrato'))->format('Y-m-d');
        $finalizacion_contrato = Carbon::createFromFormat('d-m-Y', $request->input('finalizacion_contrato'))->format('Y-m-d');

        $empleado->informacionLarabol()->update([
            // Campos de InformacionLarabol para actualizar
            'fecha_contrato' => $fecha_contrato,
            'finalizacion_contrato' => $finalizacion_contrato,
            'tipo_contrato' => $request->input('tipo_contrato'),
            'tipo_salario' => $request->input('tipo_salario'),
            'salario' => $request->input('salario'),
        ]);
    }

    private function updateDocumentoRequirido(Empleado $empleado, Request $request)
    {
        $empleado->documentoRequirido()->update([
            // Campos de DocumentoRequirido para actualizar
            'curriculum_vitae' => $request->input('curriculum_vitae'),
            'cedula_identidad' => $request->input('cedula_identidad'),
            'seguro_social' => $request->input('seguro_social'),
            'titulos_certificados' => $request->input('titulos_certificados'),
            'otros_documentos' => $request->input('otros_documentos'),
        ]);
    }

    private function updateHistorialEmpresaAnterior(Empleado $empleado, Request $request)
    {
        if($request->has('fecha_inicio_trabajo_anterior')) {
            $fecha_inicio_trabajo_anterior = Carbon::createFromFormat('d-m-Y', $request->input('fecha_inicio_trabajo_anterior'))->format('Y-m-d');
        }else {
            $fecha_inicio_trabajo_anterior = null;
        }
        
        if ($request->has('fecha_salida_trabajo_anterior')) {
            $fecha_salida_trabajo_anterior = Carbon::createFromFormat('d-m-Y', $request->input('fecha_salida_trabajo_anterior'))->format('Y-m-d');
        } else {
            $fecha_salida_trabajo_anterior = null;
        }

        $empleado->historialEmpresaAnterior()->update([
            // Campos de HistorialEmpresaAnterior para actualizar
            'nombre_empresa_anterior' => $request->input('nombre_empresa_anterior'),
            'cargo_anterior' => $request->input('cargo_anterior'),
            'fecha_inicio_trabajo_anterior' => $fecha_inicio_trabajo_anterior,
            'fecha_salida_trabajo_anterior' => $fecha_salida_trabajo_anterior,
            'motivo_salida' => $request->input('motivo_salida'),
        ]);
    }

    public function destroy($id)
    {
        // Buscar el empleado por su ID
        $empleado = Empleado::find($id);

        if (!$empleado) {
            return response()->json(['success' => false, 'message' => 'No se encontró un empleado con el ID especificado'], 404);
        }

        try {
            // Eliminar el empleado
            $empleado->delete();

            return response()->json([
                'success' => true,
                'message' => 'Empleado eliminado exitosamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el empleado',
                'errors' => [$e->getMessage()]
            ], 500);
        }
    }
}
