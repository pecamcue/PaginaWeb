<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Categoria;
use App\Models\ProductImage;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function productosPorCategoria($categoria_id)
    {
        try {
            $categoria = Categoria::with('products')->findOrFail($categoria_id);
            return view('admin.products.productos_categoria', compact('categoria'));
        } catch (QueryException $e) {
            return redirect()->route('admin.panel')->withErrors(['error' => 'Error al acceder a la categoría: ' . $e->getMessage()]);
        }
    }

    public function crearProducto()
    {
        try {
            $categorias = Categoria::all();
            return view('admin.products.crear_producto', compact('categorias'));
        } catch (QueryException $e) {
            return redirect()->route('admin.panel')->withErrors(['error' => 'Error al cargar las categorías: ' . $e->getMessage()]);
        }
    }

    public function guardarProducto(Request $request)
    {
        try {
            $categoria = Categoria::find($request->categoria_id);
            if (!$categoria) {
                return redirect()->back()->withErrors(['error' => 'La categoría seleccionada no existe.']);
            }

            $flexibles = ['lentes de contacto', 'accesorios', 'pilas', 'liquidos'];
            $nombreCat = strtolower($categoria->nombre);

            $request->validate([
                'modelo' => 'required|string|max:255',
                'marca' => 'required|string|max:255',
                'precio' => 'required|numeric',
                'categoria_id' => 'required|exists:categorias,id',
                'imagen' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
                'slug' => 'required|string|unique:products,slug',
                'stock' => 'required|integer|min:0',
                'activo' => 'required|boolean',
                'oferta' => 'required|boolean',
                'imagenes' => 'nullable|array',
                'imagenes.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            ]);

            if (!in_array($nombreCat, $flexibles)) {
                $rules = [
                    'genero' => 'required|in:Hombre,Mujer,Unisex,Infantil',
                    'tamano' => 'required|string',
                    'color_montura' => 'required|string',
                    'material_montura' => 'required|string',
                ];

                if (str_contains($nombreCat, 'sol')) {
                    $rules['color_cristal'] = 'required|string';
                    $rules['tipo_cristal'] = 'required|string';
                }

                $request->validate($rules);
            }

            if ($nombreCat === 'lentes de contacto') {
                $request->validate([
                    'tipo_lentilla' => 'required|in:esferica,torica,multifocal',
                ]);
            }

            $data = $request->only([
                'modelo', 'marca', 'precio', 'genero', 'tamano', 'color_montura', 'color_cristal',
                'tipo_cristal', 'material_montura', 'descripcion', 'informacion_adicional', 'stock',
                'activo', 'oferta', 'precio_oferta', 'slug', 'categoria_id', 'tipo_lentilla'
            ]);

            if (in_array($nombreCat, $flexibles)) {
                $data['genero'] = $data['tamano'] = $data['color_montura'] = $data['color_cristal'] = $data['tipo_cristal'] = $data['material_montura'] = null;
            }

            if (!str_contains($nombreCat, 'sol')) {
                $data['color_cristal'] = null;
                $data['tipo_cristal'] = null;
            }

            if ($nombreCat !== 'lentes de contacto') {
                $data['tipo_lentilla'] = null;
            }

            $product = Product::create($data);

            if ($request->hasFile('imagen')) {
                $product->imagen = $request->file('imagen')->store('productos', 'public');
                $product->save();
            }

            if ($request->hasFile('imagenes')) {
                foreach ($request->file('imagenes') as $image) {
                    if ($image->isValid()) {
                        $path = $image->store('productos', 'public');
                        $product->images()->create(['path' => $path]); 
                    }
                }
            }

            return redirect()->route('admin.panel')->with('success', 'Producto creado correctamente.');
        } catch (QueryException $e) {
            return redirect()->back()->withErrors(['error' => 'Error al crear el producto: ' . $e->getMessage()]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Error inesperado: ' . $e->getMessage()]);
        }
    }

    public function editarProducto($id)
    {
        try {
            $producto = Product::with('images')->findOrFail($id);
            $categorias = Categoria::all();
            return view('admin.products.editar_producto', compact('producto', 'categorias'));
        } catch (QueryException $e) {
            return redirect()->route('admin.panel')->withErrors(['error' => 'Error al cargar el producto: ' . $e->getMessage()]);
        }
    }

    public function actualizarProducto(Request $request, Product $producto)
    {
        $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'modelo' => 'required|string|max:255',
            'marca' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'imagen' => 'nullable|image|max:2048', 
            'precio_oferta' => 'nullable|numeric|min:0|lt:precio',
            'color_lentilla.*' => 'nullable|string|max:100', 
            'replace_image.*' => 'nullable|image|max:2048', 
            'new_color_names.*' => 'nullable|string|max:50', 
            'new_color_images.*' => 'nullable|image|max:2048',
            'imagenes.*' => 'nullable|image|max:2048'
        ]);
        
        try {
            DB::transaction(function () use ($request, $producto) { 
                $categoria = Categoria::findOrFail($request->categoria_id);
                $nombreCat = strtolower($categoria->nombre);

                // 1. Datos básicos
                $data = $request->except(['_token', '_method', 'color_lentilla', 'replace_image', 'new_color_names', 'new_color_images', 'imagenes']);
                $data['oferta'] = $request->has('oferta') ? 1 : 0;
                $data['precio_oferta'] = $data['oferta'] ? $request->precio_oferta : null;

                // 2. Limpieza según categoría
                if (!str_contains($nombreCat, 'sol')) {
                    $data['color_cristal'] = null;
                    $data['tipo_cristal'] = null;
                }

                if (!str_contains($nombreCat, 'gafas') && !str_contains($nombreCat, 'vista') && !str_contains($nombreCat, 'sol')) {
                    $data['genero'] = $data['tamano'] = $data['color_montura'] = $data['material_montura'] = null;
                }

                if ($nombreCat !== 'lentes de contacto') {
                    $data['tipo_lentilla'] = null;
                }

                // 3. Imagen principal
                if ($request->hasFile('imagen')) {
                    if ($producto->imagen && Storage::disk('public')->exists($producto->imagen)) {
                        Storage::disk('public')->delete($producto->imagen);
                    }
                    $data['imagen'] = $request->file('imagen')->store('products', 'public');
                }
                
                $producto->update($data);
                
                // 4. Gestión de Colores Existentes (Lentillas)
                if ($request->has('color_lentilla')) {
                    foreach ($request->input('color_lentilla') as $imageId => $colorName) {
                        $image = ProductImage::find($imageId);
                        if ($image) {
                            $updateData = ['color_lentilla' => $colorName];
                            if ($request->hasFile("replace_image.$imageId")) {
                                if (Storage::disk('public')->exists($image->path)) {
                                    Storage::disk('public')->delete($image->path);
                                }
                                $updateData['path'] = $request->file("replace_image.$imageId")->store('products', 'public');
                            }
                            $image->update($updateData);
                        }
                    }
                }
                
                // 5. Añadir Nuevos Colores (Lentillas)
                $newColorNames = $request->input('new_color_names', []);
                $newImageFiles = $request->file('new_color_images', []);

                if (!empty($newImageFiles)) {
                    foreach ($newImageFiles as $index => $newImageFile) {
                        $newColorName = $newColorNames[$index] ?? null;
                        if ($newImageFile && $newImageFile->isValid()) {
                            $path = $newImageFile->store('products', 'public');
                            $producto->images()->create([
                                'path' => $path,
                                'color_lentilla' => $newColorName,
                            ]);
                        }
                    }
                }
                
                // 6. Añadir Imágenes Generales (Gafas, Accesorios, etc)
                if ($request->hasFile('imagenes')) {
                    foreach ($request->file('imagenes') as $imgFile) {
                        if ($imgFile->isValid()) {
                            $path = $imgFile->store('products', 'public');
                            $producto->images()->create(['path' => $path, 'color_lentilla' => null]);
                        }
                    }
                }
            }); 
            
            return redirect()->route('admin.producto.editar', $producto->id)->with('success', 'Producto actualizado correctamente.');
            
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Error al actualizar: ' . $e->getMessage()]);
        }
    }

    public function eliminarProducto($id)
    {
        try {
            $product = Product::findOrFail($id);
            if ($product->imagen) {
                Storage::disk('public')->delete($product->imagen);
            }
            foreach ($product->images as $image) {
                if (Storage::disk('public')->exists($image->path)) {
                    Storage::disk('public')->delete($image->path);
                }
                $image->delete();
            }
            $product->delete();
            return redirect()->route('admin.panel')->with('success', 'Producto eliminado correctamente.');
        } catch (QueryException $e) {
            return redirect()->route('admin.panel')->withErrors(['error' => 'Error al eliminar el producto: ' . $e->getMessage()]);
        }
    }

    public function eliminarImagen(ProductImage $image)
    {
        $productId = $image->product_id; 
        try {
            DB::transaction(function () use ($image) {
                if (Storage::disk('public')->exists($image->path)) {
                    Storage::disk('public')->delete($image->path);
                }
                $image->delete();
            });
            return redirect()->route('admin.producto.editar', $productId)->with('success', 'Imagen eliminada correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Error al eliminar la imagen: ' . $e->getMessage()]);
        }
    }

    public function panel()
    {
        try {
            $productos = Product::with('categoria')->get();
            return view('admin.products.panel', compact('productos'));
        } catch (QueryException $e) {
            return view('admin.products.panel')->withErrors(['error' => 'Error al cargar los productos: ' . $e->getMessage()]);
        }
    }

    public function ordersIndex(Request $request)
    {
        $query = Order::with(['user', 'orderItems.product'])->orderBy('order_date', 'desc');
        if ($request->filled('status')) $query->where('status', $request->status);
        if ($request->filled('payment_status')) $query->where('payment_status', $request->payment_status);
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }
        $orders = $query->paginate(10);
        $statuses = ['pendiente', 'enviado', 'completado', 'cancelado'];
        $paymentStatuses = ['pendiente', 'pagado', 'cancelado', 'reembolsado'];
        return view('admin.orders.index', compact('orders', 'statuses', 'paymentStatuses'));
    }

    public function ordersShow(Order $order)
    {
        $order->load(['user', 'orderItems.product', 'orderItems.options']);
        return view('admin.orders.show', compact('order'));
    }

    public function ordersUpdateStatus(Request $request, Order $order)
    {
        $request->validate(['status' => ['required', Rule::in(['pendiente', 'enviado', 'completado', 'cancelado'])]]);
        $order->update(['status' => $request->status]);
        return redirect()->route('admin.orders.show', $order)->with('success', "Estado actualizado.");
    }

    public function ordersUpdatePaymentStatus(Request $request, Order $order)
    {
        $request->validate(['payment_status' => ['required', Rule::in(['pendiente', 'pagado', 'cancelado', 'reembolsado'])]]);
        $order->update(['payment_status' => $request->payment_status]);
        return redirect()->route('admin.orders.show', $order)->with('success', "Pago actualizado.");
    }

    public function ordersChangeStatus(Request $request, Order $order)
    {
        $request->validate(['status' => ['required', Rule::in(['pendiente', 'enviado', 'completado', 'cancelado'])]]);
        $order->update(['status' => $request->status]);
        return response()->json([
            'success' => true,
            'new_status' => $order->fresh()->status_label,
            'badge_class' => $order->fresh()->status_badge_class
        ]);
    }

    public function ordersChangePaymentStatus(Request $request, Order $order)
    {
        $request->validate(['payment_status' => ['required', Rule::in(['pendiente', 'pagado', 'cancelado', 'reembolsado'])]]);
        $order->update(['payment_status' => $request->payment_status]);
        return response()->json([
            'success' => true,
            'new_status' => $order->fresh()->payment_status_label,
            'badge_class' => $order->fresh()->payment_status_badge_class
        ]);
    }

    public function ordersCancel(Order $order)
    {
        DB::transaction(function () use ($order) {
            $order->update(['status' => 'cancelado', 'payment_status' => 'reembolsado']);
        });
        return redirect()->route('admin.orders.show', $order)->with('success', 'Pedido cancelado.');
    }
}