<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Departamentos;
use App\Http\Controllers\Controller;

class DepartamentoController extends Controller
{
      /**
     * Mostrar una lista de los departamentos.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departamentos = Departamentos::all();

        return response()->json([
            'success' => true,
            'data' => $departamentos,
        ]);
    }

    /**
     * Almacenar un nuevo departamento.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:departamentos|max:255',
        ], [
            'name.required' => 'El campo de Departamento es obligatorio.',
            'name.unique' => 'Ya existe un departamento con ese nombre.',
        ]);

        $departamentos = Departamentos::create([
            'name' => $request->input('name'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Departamento creado exitosamente',
            'data' => $departamentos,
        ], 201);
    }

    /**
     * Mostrar el departamento especificado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $departamentos = Departamentos::find($id);

        if (!$departamentos) {
            return response()->json([
                'success' => false,
                'message' => 'Departamento no encontrado',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $departamentos,
        ]);
    }

    /**
     * Actualizar el departamento especificado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:departamentos|max:255',
        ], [
            'name.required' => 'El campo de Departamento es obligatorio.',
            'name.unique' => 'Ya existe un departamento con ese nombre.',
        ]);

        $departamentos = Departamentos::find($id);

        if (!$departamentos) {
            return response()->json([
                'success' => false,
                'message' => 'Departamento no encontrado',
            ], 404);
        }

        $departamentos->name = $request->input('name');
        $departamentos->save();

        return response()->json([
            'success' => true,
            'message' => 'Departamento actualizado exitosamente',
            'data' => $departamentos,
        ]);
    }

    /**
     * Eliminar el departamento especificado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $departamentos = Departamentos::find($id);

        if (!$departamentos) {
            return response()->json([
                'success' => false,
                'message' => 'Departamento no encontrado',
            ], 404);
        }

        $departamentos->delete();

        return response()->json([
            'success' => true,
            'message' => 'Departamento eliminado exitosamente',
        ]);
    }

    /**
     * Obtener los empleados de un departamento específico.
     *
     * @param  int  $departamentoId
     * @return \Illuminate\Http\Response
     */
    public function getEmployees($departamentoId)
    {
        $departamentos = Departamentos::find($departamentoId);

        if (!$departamentos) {
            return response()->json([
                'success' => false,
                'message' => 'Departamento no encontrado',
            ], 404);
        }

        $empleados = $departamentos->empleado;

        return response()->json([
            'success' => true,
            'data' => $empleados,
        ]);
    }
}
