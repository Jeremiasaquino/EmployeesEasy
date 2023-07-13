<?php

namespace App\Http\Controllers\Api;

use App\Models\Empleado;
use App\Models\Posiciones;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PosicionController extends Controller
{
    /**
     * Muestra una lista de todas las posiciones.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $positions = Posiciones::all();

        return response()->json([
            'success' => true,
            'data' => $positions,
        ]);
    }

    /**
     * Almacena una nueva posición.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'posicion' => 'required|unique:posiciones|max:255',
            ],
            [
                'posicion.required' => 'El campo de Posicion es obligatorio.',
                'posicion.unique' => 'Ya existe una posición con este nombre en el departamento seleccionado.',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $validator->errors(),
            ], 422);
        }

        $position = Posiciones::create([
            'posicion' => $request->input('posicion'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Posición creada exitosamente',
            'msgDescription' => 'Posicion Registrada!',
            'data' => $position,
        ], 201);
    }

    /**
     * Muestra la posición especificada.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $position = Posiciones::find($id);

        if (!$position) {
            return response()->json([
                'success' => false,
                'message' => 'Posición no encontrada',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $position,
        ]);
    }

    /**
     * Actualiza la posición especificada.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'posicion' => 'required|unique:posiciones|max:255',
        ], [
            'posicion.required' => 'El campo de Posicion es obligatorio.',
            'posicion.unique' => 'Ya existe una posición con este nombre en el campo seleccionado.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $validator->errors(),
            ], 422);
        }

        $position = Posiciones::find($id);

        if (!$position) {
            return response()->json([
                'success' => false,
                'message' => 'Posición no encontrada',
            ], 404);
        }

        $position->posicion = $request->input('posicion');
        $position->save();

        return response()->json([
            'success' => true,
            'message' => 'Posición actualizada exitosamente',
            'msgDescription' => 'Posicion Modificada!',
            'data' => $position,
        ]);
    }

    /**
     * Elimina la posición especificada.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $position = Posiciones::find($id);

        if (!$position) {
            return response()->json([
                'success' => false,
                'message' => 'Posición no encontrada',
            ], 404);
        }

        $position->delete();

        return response()->json([
            'success' => true,
            'message' => 'Posición eliminada exitosamente',
        ]);
    }

    /**
     * Obtiene los empleados de una posición.
     *
     * @param  int  $positionId
     * @return \Illuminate\Http\Response
     */
    public function getEmployees($positionId)
    {
        $posiciones = Posiciones::find($positionId);

        if (!$posiciones) {
            return response()->json([
                'success' => false,
                'message' => 'Posicion no encontrado',
            ], 404);
        }

        $empleados = $posiciones->empleado;

        return response()->json([
            'success' => true,
            'data' => $empleados,
        ]);

        // $employees = Empleado::where('posicione_id', $positionId)->get();

        // return response()->json([
        //     'success' => true,
        //     'data' => $employees,
        // ]);
    }
}
