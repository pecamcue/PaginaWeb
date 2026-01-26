<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Resenya;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ResenyaController extends Controller
{
    /**
     * Obtener reseñas de un producto (público)
     */
    public function index($productId)
    {
        $resenyas = Resenya::with('user:id,name')
            ->where('product_id', $productId)
            ->orderBy('created_at', 'desc')
            ->get();

        // Transforma a formato frontend: usuario, comentario, fecha formateada
        $resenyasTransformadas = $resenyas->map(function ($resenya) {
            return [
                'id' => $resenya->id,
                'usuario' => $resenya->user->name ?? 'Usuario Anónimo',
                'rating' => $resenya->rating,
                'comentario' => $resenya->comentario,
                'fecha' => $resenya->created_at->format('d/m/Y H:i'),
            ];
        });

        return response()->json($resenyasTransformadas);
    }

    /**
     * Crear una reseña (solo para usuarios autenticados)
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'producto_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Verifica si el usuario ya reseñó este producto
        $existing = Resenya::where('user_id', Auth::id())
            ->where('product_id', $request->producto_id)
            ->first();

        if ($existing) {
            return response()->json(['error' => 'Ya has reseñado este producto.'], 409);
        }

        $resenya = Resenya::create([
            'user_id' => Auth::id(),
            'product_id' => $request->producto_id,
            'rating' => $request->rating,
            'comentario' => $request->comentario,
        ]);

        // Carga user y transforma respuesta a formato frontend
        $resenya->load('user:id,name');
        $resenyaTransformada = [
            'id' => $resenya->id,
            'usuario' => $resenya->user->name ?? 'Usuario Anónimo',
            'rating' => $resenya->rating,
            'comentario' => $resenya->comentario,
            'fecha' => $resenya->created_at->format('d/m/Y H:i'),
        ];

        return response()->json($resenyaTransformada, 201);
    }
}