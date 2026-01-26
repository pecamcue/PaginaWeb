<?php

namespace App\Http\Controllers;

use App\Models\Graduacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GraduacionController extends Controller
{
    public function gestionar()
    {
        $graduaciones = Graduacion::where('user_id', Auth::id())->get();
        return view('portal_user.graduacion.manage_graduacion', compact('graduaciones'));
    }

    public function guardar(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'nullable|string|in:Gafa progresiva,Lentillas,Gafa de lejos,Gafa de cerca',
            'od_esfera' => 'nullable|numeric|between:-20,20',
            'od_cilindro' => 'nullable|numeric|between:-20,20',
            'od_eje' => 'nullable|integer|between:0,180',
            'od_adicion' => 'nullable|numeric|between:0,3|in:0,0.5,1,1.5,2,2.5,3',
            'os_esfera' => 'nullable|numeric|between:-20,20',
            'os_cilindro' => 'nullable|numeric|between:-20,20',
            'os_eje' => 'nullable|integer|between:0,180',
            'os_adicion' => 'nullable|numeric|between:0,3|in:0,0.5,1,1.5,2,2.5,3',
        ]);

        try {
            $graduacion = Graduacion::create(array_merge($validated, [
                'user_id' => Auth::id(),
                'od_adicion' => $request->nombre === 'Gafa de lejos' || $request->nombre === 'Gafa de cerca' ? null : $request->od_adicion,
                'os_adicion' => $request->nombre === 'Gafa de lejos' || $request->nombre === 'Gafa de cerca' ? null : $request->os_adicion,
            ]));

            return response()->json([
                'success' => true,
                'message' => 'Graduación creada correctamente'
            ]);
        } catch (\Exception $e) {
            Log::error('Error al crear graduación: ' . $e->getMessage());
            return response()->json(['error' => 'Error al crear la graduación: ' . $e->getMessage()], 500);
        }
    }

    public function actualizar(Request $request, Graduacion $graduacion)
    {
        if ($graduacion->user_id !== Auth::id()) {
            return response()->json(['error' => 'No tienes permiso para modificar esta graduación.'], 403);
        }

        $validated = $request->validate([
            'nombre' => 'nullable|string|in:Gafa progresiva,Lentillas,Gafa de lejos,Gafa de cerca',
            'od_esfera' => 'nullable|numeric|between:-20,20',
            'od_cilindro' => 'nullable|numeric|between:-20,20',
            'od_eje' => 'nullable|integer|between:0,180',
            'od_adicion' => 'nullable|numeric|between:0,3|in:0,0.5,1,1.5,2,2.5,3',
            'os_esfera' => 'nullable|numeric|between:-20,20',
            'os_cilindro' => 'nullable|numeric|between:-20,20',
            'os_eje' => 'nullable|integer|between:0,180',
            'os_adicion' => 'nullable|numeric|between:0,3|in:0,0.5,1,1.5,2,2.5,3',
        ]);

        try {
            $graduacion->update(array_merge($validated, [
                'od_adicion' => $request->nombre === 'Gafa de lejos' || $request->nombre === 'Gafa de cerca' ? null : $request->od_adicion,
                'os_adicion' => $request->nombre === 'Gafa de lejos' || $request->nombre === 'Gafa de cerca' ? null : $request->os_adicion,
            ]));

            return response()->json([
                'success' => true,
                'message' => 'Graduación actualizada correctamente'
            ]);
        } catch (\Exception $e) {
            Log::error('Error al actualizar graduación: ' . $e->getMessage());
            return response()->json(['error' => 'Error al actualizar la graduación: ' . $e->getMessage()], 500);
        }
    }

    public function eliminar(Graduacion $graduacion)
    {
        if ($graduacion->user_id !== Auth::id()) {
            return response()->json(['error' => 'No tienes permiso para eliminar esta graduación.'], 403);
        }

        try {
            $graduacion->delete();

            return response()->json([
                'success' => true,
                'message' => 'Graduación eliminada correctamente'
            ]);
        } catch (\Exception $e) {
            Log::error('Error al eliminar graduación: ' . $e->getMessage());
            return response()->json(['error' => 'Error al eliminar la graduación: ' . $e->getMessage()], 500);
        }
    }
}