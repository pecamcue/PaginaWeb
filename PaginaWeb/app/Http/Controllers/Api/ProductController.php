<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Categoria;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['categoria', 'images'])->get();
        return response()->json($products);
    }

    public function show($id)
    {
        try {
            $product = Product::with(['categoria', 'images', 'resenyas'])->findOrFail($id);
            return response()->json($product, 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Producto no encontrado',
                'message' => $e->getMessage()
            ], 404);
        }
    }

    // MÉTODO CORREGIDO: Filtros insensibles a mayúsculas y con mapeo para acentos
    public function porCategoriaNombre(Request $request, $slug)
    {
        $categoria = Categoria::where('slug', $slug)->firstOrFail();

        $query = Product::with(['categoria', 'images'])
            ->where('categoria_id', $categoria->id)
            ->where('activo', true); // Solo productos activos (opcional, pero recomendado)

        /**
         * 🔍 BUSCADOR POR TEXTO (insensible a mayúsculas)
         */
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;

            $query->where(function ($q) use ($buscar) {
                $q->whereRaw('LOWER(modelo) LIKE ?', ['%' . strtolower($buscar) . '%'])
                  ->orWhereRaw('LOWER(marca) LIKE ?', ['%' . strtolower($buscar) . '%'])
                  ->orWhereRaw('LOWER(descripcion) LIKE ?', ['%' . strtolower($buscar) . '%']);
            });
        }

        // 🎛️ FILTROS CON COMPARACIÓN INSENSIBLE A MAYÚSCULAS
        $query->when($request->filled('marca'), function ($q) use ($request) {
            $q->whereRaw('LOWER(marca) = ?', [strtolower($request->marca)]);
        });

        $query->when($request->filled('genero'), function ($q) use ($request) {
            $q->whereRaw('LOWER(genero) = ?', [strtolower($request->genero)]);
        });

        $query->when($request->filled('tipo_cristal'), function ($q) use ($request) {
            $q->whereRaw('LOWER(tipo_cristal) = ?', [strtolower($request->tipo_cristal)]);
        });

        $query->when($request->filled('tipo_lentilla'), function ($q) use ($request) {
            $q->whereRaw('LOWER(tipo_lentilla) = ?', [strtolower($request->tipo_lentilla)]);
        });

        // Frecuencia (diaria / mensual) en lentillas
        $query->when($request->filled('frecuencia'), function ($q) use ($request) {
            $q->whereRaw('LOWER(frecuencia) = ?', [strtolower($request->frecuencia)]);
        });

        // Subtipo en accesorios y líquidos (estuches, audiologia, etc.)
        $query->when($request->filled('subtipo'), function ($q) use ($request) {
            $valor = strtolower($request->subtipo);

            // Mapeo para valores comunes con acentos o diferencias de formato
            $map = [
                'audiologia' => 'Audiología',
                'estuches'   => 'Estuches',
                'colgantes'  => 'Colgantes / Cordones',
                'limpieza'   => 'Limpieza',
                'gotas'      => 'Gotas',
            ];

            $valorNormalizado = $map[$valor] ?? $valor;

            $q->whereRaw('LOWER(subtipo) = ?', [strtolower($valorNormalizado)]);
        });

        // Orden (puedes cambiarlo si quieres)
        $query->orderBy('id', 'desc');

        return response()->json($query->get());
    }

    public function verProductoPorSlug($slug)
    {
        $product = Product::where('slug', $slug)
                          ->with(['categoria', 'images', 'opciones'])
                          ->firstOrFail();

        $coloresDisponibles = $product->opciones
                                      ->pluck('color_sol')
                                      ->unique()
                                      ->filter()
                                      ->values();

        $imagenesPorColor = $product->images
                                   ->whereNotNull('color_lentilla')
                                   ->pluck('path', 'color_lentilla');

        $imagenPrincipal = $product->images
                           ->where('color_lentilla', null)
                           ->first();

        $imagenPrincipalPath = $imagenPrincipal 
                               ? $imagenPrincipal->path 
                               : ($product->images->first()->path ?? $product->imagen);

        return response()->json([
            'product' => $product,
            'colores_disponibles' => $coloresDisponibles,
            'imagenes_por_color' => $imagenesPorColor,
            'imagen_principal_path' => $imagenPrincipalPath,
        ]);
    }

    public function ver($id)
    {
        $product = Product::with(['categoria', 'images'])->findOrFail($id);
        return response()->json($product);
    }

    public function store(Request $request)
    {
        $request->validate([
            'modelo' => 'required|string|max:255',
            'marca' => 'nullable|string|max:255',
            'precio' => 'required|numeric',
            'genero' => 'nullable|string|max:255',
            'tamano' => 'nullable|string|max:255',
            'color_montura' => 'nullable|string|max:255',
            'color_cristal' => 'nullable|string|max:255',
            'tipo_cristal' => 'nullable|string|max:255',
            'material_montura' => 'nullable|string|max:255',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'descripcion' => 'nullable|string',
            'informacion_adicional' => 'nullable|string',
            'stock' => 'nullable|integer',
            'activo' => 'nullable|boolean',
            'oferta' => 'nullable|boolean',
            'precio_oferta' => 'nullable|numeric',
            'slug' => 'required|string|unique:products,slug',
            'categoria_id' => 'required|exists:categorias,id',
            'tipo_lentilla' => 'nullable|string',
            'frecuencia' => 'nullable|string|max:255',
            'subtipo' => 'nullable|string|max:255',
            'imagenes' => 'nullable|array',
            'imagenes.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $productData = $request->only([
            'modelo', 'marca', 'precio', 'genero', 'tamano', 'color_montura', 'color_cristal',
            'tipo_cristal', 'material_montura', 'descripcion', 'informacion_adicional', 'stock',
            'activo', 'oferta', 'precio_oferta', 'slug', 'categoria_id', 'tipo_lentilla',
            'frecuencia', 'subtipo'
        ]);

        if ($request->hasFile('imagen')) {
            $productData['imagen'] = $request->file('imagen')->store('products', 'public');
        }

        $product = Product::create($productData);

        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $image) {
                if ($image->isValid()) {
                    $path = $image->store('products', 'public');
                    $product->images()->create(['path' => $path]);
                }
            }
        }

        return response()->json($product->load('images'), 201);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'modelo' => 'required|string|max:255',
            'marca' => 'nullable|string|max:255',
            'precio' => 'required|numeric',
            'genero' => 'nullable|string|max:255',
            'tamano' => 'nullable|string|max:255',
            'color_montura' => 'nullable|string|max:255',
            'color_cristal' => 'nullable|string|max:255',
            'tipo_cristal' => 'nullable|string|max:255',
            'material_montura' => 'nullable|string|max:255',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'descripcion' => 'nullable|string',
            'informacion_adicional' => 'nullable|string',
            'stock' => 'nullable|integer',
            'activo' => 'nullable|boolean',
            'oferta' => 'nullable|boolean',
            'precio_oferta' => 'nullable|numeric',
            'slug' => 'required|string|unique:products,slug,' . $id,
            'categoria_id' => 'required|exists:categorias,id',
            'tipo_lentilla' => 'nullable|string',
            'frecuencia' => 'nullable|string|max:255',
            'subtipo' => 'nullable|string|max:255',
            'imagenes' => 'nullable|array',
            'imagenes.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $productData = $request->only([
            'modelo', 'marca', 'precio', 'genero', 'tamano', 'color_montura', 'color_cristal',
            'tipo_cristal', 'material_montura', 'descripcion', 'informacion_adicional', 'stock',
            'activo', 'oferta', 'precio_oferta', 'slug', 'categoria_id', 'tipo_lentilla',
            'frecuencia', 'subtipo'
        ]);

        if ($request->hasFile('imagen')) {
            if ($product->imagen) {
                Storage::disk('public')->delete($product->imagen);
            }
            $productData['imagen'] = $request->file('imagen')->store('products', 'public');
        }

        $product->update($productData);

        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $image) {
                if ($image->isValid()) {
                    $path = $image->store('products', 'public');
                    $product->images()->create(['path' => $path]);
                }
            }
        }

        return response()->json($product->load('images'));
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->imagen) {
            Storage::disk('public')->delete($product->imagen);
        }

        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->path);
            $image->delete();
        }

        $product->delete();

        return response()->json(null, 204);
    }

    public function eliminarImagen($id)
    {
        $image = ProductImage::findOrFail($id);
        Storage::disk('public')->delete($image->path);
        $image->delete();
        return response()->json(['message' => 'Imagen eliminada correctamente.']);
    }

    /**
     * NUEVO: Obtiene marcas únicas coherentes con la categoría actual.
     */
    public function obtenerMarcasPorCategoria($slug)
    {
        $categoria = Categoria::where('slug', $slug)->firstOrFail();
        
        $marcas = Product::where('categoria_id', $categoria->id)
            ->whereNotNull('marca')
            ->where('marca', '!=', '')
            ->distinct()
            ->orderBy('marca', 'asc')
            ->pluck('marca');

        return response()->json($marcas);
    }
}