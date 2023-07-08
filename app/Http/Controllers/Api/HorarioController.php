<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Horarios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class HorarioController extends Controller
{
     /**
     * Listar todos los horarios.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $horarios = Horarios::all();

        return response()->json([
            'success' => true,
            'data' => $horarios
        ]);
    }

    /**
     * Crear un nuevo horario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validar la solicitud
        $validator = Validator::make($request->all(), [
            'hora_entrada' => 'required|date_format:h:i:s A', // Ejemplo: 12:00:00 PM
            'hora_salida' => 'required|date_format:h:i:s A', // Ejemplo: 01:00:00 AM
            'dias_semana' => 'required|array',
            'dias_semana.*' => 'required|string|in:Lunes,Martes,Miércoles,Jueves,Viernes,Sábado,Domingo'
        ], [
            'hora_entrada.required' => 'La hora de entrada es requerida.',
            'hora_entrada.date_format' => 'La hora de entrada debe estar en formato HH:MM:SS AM/PM.',
            'hora_salida.required' => 'La hora de salida es requerida.',
            'hora_salida.date_format' => 'La hora de salida debe estar en formato HH:MM:SS AM/PM.',
            'dias_semana.required' => 'Los días de la semana son requeridos.',
            'dias_semana.array' => 'Los días de la semana deben ser proporcionados como un arreglo.',
            'dias_semana.*.in' => 'El valor :attribute no es un día válido de la semana.'
        ]);

        // Si la validación falla, devolver errores
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Formatear la fecha de entrada y salida utilizando Carbon
        $horaEntrada = Carbon::createFromFormat('h:i:s A', $request->input('hora_entrada'))->format('H:i:s');
        $horaSalida = Carbon::createFromFormat('h:i:s A', $request->input('hora_salida'))->format('H:i:s');

        // Crear el nuevo horario con las fechas formateadas
        $horario = Horarios::create([
            'hora_entrada' => $horaEntrada,
            'hora_salida' => $horaSalida,
            'dias_semana' => $request->input('dias_semana')
        ]);

        return response()->json([
            'success' => true,
            'data' => $horario,
            'message' => 'Horario creado exitosamente.'
        ]);
    }

    /**
     * Mostrar un horario específico.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $horario = Horarios::find($id);

        // Si no se encuentra el horario, devolver mensaje de error
        if (!$horario) {
            return response()->json([
                'success' => false,
                'message' => 'Horario no encontrado.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $horario
        ]);
    }

    /**
     * Actualizar un horario existente.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        // Validar la solicitud
        $validator = Validator::make($request->all(), [
            'hora_entrada' => 'required|date_format:h:i:s A', // Ejemplo: 12:00:00 PM
            'hora_salida' => 'required|date_format:h:i:s A', // Ejemplo: 01:00:00 AM
            'dias_semana' => 'required|array',
            'dias_semana.*' => 'required|string|in:Lunes,Martes,Miércoles,Jueves,Viernes,Sábado,Domingo'
        ], [
            'hora_entrada.required' => 'La hora de entrada es requerida.',
            'hora_entrada.date_format' => 'La hora de entrada debe estar en formato HH:MM:SS AM/PM.',
            'hora_salida.required' => 'La hora de salida es requerida.',
            'hora_salida.date_format' => 'La hora de salida debe estar en formato HH:MM:SS AM/PM.',
            'dias_semana.required' => 'Los días de la semana son requeridos.',
            'dias_semana.array' => 'Los días de la semana deben ser proporcionados como un arreglo.',
            'dias_semana.*.in' => 'El valor :attribute no es un día válido de la semana.'
        ]);

        // Si la validación falla, devolver errores
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $horario = Horarios::find($id);

        // Si no se encuentra el horario, devolver mensaje de error
        if (!$horario) {
            return response()->json([
                'success' => false,
                'message' => 'Horario no encontrado.'
            ], 404);
        }

        // Formatear la fecha de entrada y salida utilizando Carbon
        $horaEntrada = Carbon::createFromFormat('h:i:s A', $request->input('hora_entrada'))->format('H:i:s');
        $horaSalida = Carbon::createFromFormat('h:i:s A', $request->input('hora_salida'))->format('H:i:s');

        // Actualizar el horario
        $horario->hora_entrada = $horaEntrada;
        $horario->hora_salida = $horaSalida;
        $horario->dias_semana = $request->input('dias_semana');
        $horario->save();

        return response()->json([
            'success' => true,
            'data' => $horario,
            'message' => 'Horario actualizado exitosamente.'
        ]);
    }

    /**
     * Eliminar un horario existente.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $horario = Horarios::find($id);

        // Si no se encuentra el horario, devolver mensaje de error
        if (!$horario) {
            return response()->json([
                'success' => false,
                'message' => 'Horario no encontrado.'
            ], 404);
        }

        // Eliminar el horario
        $horario->delete();

        return response()->json([
            'success' => true,
            'message' => 'Horario eliminado exitosamente.'
        ]);
    }
}
