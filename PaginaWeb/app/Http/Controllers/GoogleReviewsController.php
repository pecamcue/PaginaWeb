<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class GoogleReviewsController extends Controller
{
    public function getReviews()
    {
        // Forzar la carga del .env
        $dotenv = \Dotenv\Dotenv::createImmutable(base_path());
        $dotenv->load();

        // Obtener la clave de API y el Place ID desde el archivo .env
        $apiKey = env('GOOGLE_API_KEY');
        $placeId = env('GOOGLE_PLACE_ID');

        // Definir una clave única para el caché, incluyendo el idioma
        $cacheKey = 'google_reviews_' . $placeId . '_es';

        // Forzar limpieza del caché para pruebas (comentar esta línea en producción)
        //Cache::forget($cacheKey);

        // Intentar obtener las reseñas desde el caché (válido por 24 horas)
        $reviews = Cache::remember($cacheKey, now()->addHours(24), function () use ($apiKey, $placeId) {
            // Hacer la solicitud a la API de Google Places con idioma español
            $response = Http::get('https://maps.googleapis.com/maps/api/place/details/json', [
                'place_id' => $placeId,
                'fields' => 'reviews',
                'key' => $apiKey,
                'language' => 'es'
                
            ]);

            // Verificar el idioma de las reseñas
            $reviews = $response->successful() && isset($response->json()['result']['reviews'])
                ? $response->json()['result']['reviews']
                : [];
            return $reviews;
        });

        // Devolver las reseñas como respuesta JSON
        return response()->json([
            'success' => true,
            'reviews' => $reviews,
        ]);
    }
}