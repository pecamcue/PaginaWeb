@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Editar Producto</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.producto.actualizar', $producto->id) }}" method="POST" enctype="multipart/form-data" id="form-editar-producto">
        @csrf
        @method('PUT')

        {{-- Categoría --}}
        <div class="form-group mb-3">
            <label for="categoria_id">Categoría</label>
            <select class="form-control" name="categoria_id" id="categoria_id" required>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}" {{ old('categoria_id', $producto->categoria_id) == $categoria->id ? 'selected' : '' }}>
                        {{ $categoria->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="modelo">Modelo</label>
                <input type="text" class="form-control" name="modelo" id="modelo" value="{{ old('modelo', $producto->modelo) }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="marca">Marca</label>
                <input type="text" class="form-control" name="marca" id="marca" value="{{ old('marca', $producto->marca) }}" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="precio">Precio</label>
                <input type="number" class="form-control" name="precio" id="precio" step="0.01" value="{{ old('precio', $producto->precio) }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="stock">Stock</label>
                <input type="number" class="form-control" name="stock" id="stock" value="{{ old('stock', $producto->stock) }}" required>
            </div>
        </div>

        <div class="form-group mb-4">
            <label for="imagen">Imagen Principal Actual</label>
            @if ($producto->imagen)
                <div class="mb-2">
                    <img src="{{ url('storage/' . $producto->imagen) }}" alt="Imagen principal" width="150" height="auto" class="img-thumbnail">
                </div>
            @endif
            <input type="file" class="form-control" name="imagen" id="imagen">
        </div>
        
        <div class="form-group mb-3">
            <label for="descripcion">Descripción</label>
            <textarea class="form-control" name="descripcion" id="descripcion" rows="3">{{ old('descripcion', $producto->descripcion) }}</textarea>
        </div>

        <div class="form-group mb-4">
            <label for="informacion_adicional">Información Adicional</label>
            <textarea class="form-control" name="informacion_adicional" id="informacion_adicional" rows="3">{{ old('informacion_adicional', $producto->informacion_adicional) }}</textarea>
        </div>

        <div class="row align-items-center border p-3 rounded bg-light mb-4">
            <div class="col-md-6">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="oferta" id="oferta" value="1" {{ old('oferta', $producto->oferta) ? 'checked' : '' }}>
                    <label class="form-check-label" for="oferta">Producto en **Oferta**</label>
                </div>
            </div>
            <div class="col-md-6" id="precio_oferta_group" style="{{ old('oferta', $producto->oferta) ? 'display: block;' : 'display: none;' }}">
                <div class="form-group mb-0">
                    <label for="precio_oferta" class="small text-muted">Precio de Oferta</label>
                    <input type="number" class="form-control" name="precio_oferta" id="precio_oferta" step="0.01" value="{{ old('precio_oferta', $producto->precio_oferta) }}">
                </div>
            </div>
        </div>

        {{-- CAMPOS GAFAS --}}
        <div id="campos_gafas" style="display: none;" class="p-3 border rounded mb-4">
            <h4 class="mb-3">Especificaciones de Gafas</h4>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="genero">Género</label>
                    <input type="text" class="form-control" name="genero" id="genero" value="{{ $producto->genero }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="tamano">Tamaño</label>
                    <input type="text" class="form-control" name="tamano" id="tamano" value="{{ $producto->tamano }}">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="color_montura">Color de Montura</label>
                    <input type="text" class="form-control" name="color_montura" id="color_montura" value="{{ $producto->color_montura }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="material_montura">Material de Montura</label>
                    <input type="text" class="form-control" name="material_montura" id="material_montura" value="{{ $producto->material_montura }}">
                </div>
            </div>

            <div id="campos_gafas_sol" style="display: none;">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="color_cristal">Color de Cristal</label>
                        <input type="text" class="form-control" name="color_cristal" id="color_cristal" value="{{ $producto->color_cristal }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="tipo_cristal">Tipo de Cristal</label>
                        <input type="text" class="form-control" name="tipo_cristal" id="tipo_cristal" value="{{ $producto->tipo_cristal }}">
                    </div>
                </div>
            </div>
        </div>

        {{-- GESTIÓN DE IMÁGENES ADICIONALES --}}
        <div id="campos_imagenes_generales" style="display: none;" class="form-group p-3 border rounded bg-white mb-4">
            <h4 class="mb-3">Galería de Imágenes Adicionales</h4>
            <div class="row mb-4">
                @foreach ($producto->images as $image)
                    @if(empty($image->color_lentilla))
                        <div class="col-md-3 col-sm-4 text-center mb-3">
                            <div class="card h-100">
                                <img src="{{ url('storage/' . $image->path) }}" class="card-img-top p-2" style="height: 100px; object-fit: contain;">
                                <div class="card-body p-2">
                                    {{-- CAMBIO AQUÍ: Botón tipo submit con formulario para DELETE --}}
                                    <button type="button" class="btn btn-outline-danger btn-sm w-100" onclick="deleteImage({{ $image->id }})">🗑 Eliminar</button>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
            <div class="form-group">
                <label for="imagenes_generales">Añadir Nuevas Imágenes</label>
                <input type="file" class="form-control" name="imagenes[]" id="imagenes_generales" multiple>
            </div>
        </div>

        {{-- LENTILLAS --}}
        <div id="campos_lentillas" style="display: none;" class="p-3 border rounded mb-4">
            <h4 class="mb-3">Especificaciones de Lentillas</h4>
            <div class="form-group mb-4">
                <label for="tipo_lentilla">Tipo de Lentilla</label>
                <input type="text" class="form-control" name="tipo_lentilla" id="tipo_lentilla" value="{{ $producto->tipo_lentilla }}">
            </div>

            <div class="form-group p-3 border rounded bg-white">
                <h4 class="mb-3">Gestión de Colores</h4>
                <div class="list-group mb-4">
                    @foreach ($producto->images as $image)
                        @if(!empty($image->color_lentilla))
                            <div class="list-group-item d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-2">
                                <div class="d-flex align-items-center mb-2 mb-md-0">
                                    <img src="{{ url('storage/' . $image->path) }}" class="img-thumbnail me-3" width="50">
                                    <input type="text" class="form-control form-control-sm" name="color_lentilla[{{ $image->id }}]" value="{{ $image->color_lentilla }}" required>
                                </div>
                                <div class="d-flex align-items-center">
                                    <input type="file" class="form-control form-control-sm me-2" name="replace_image[{{ $image->id }}]">
                                    {{-- CAMBIO AQUÍ: Botón tipo submit con formulario para DELETE --}}
                                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="deleteImage({{ $image->id }})">Eliminar</button>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                <div id="new_colors_container">
                    <div class="new-color-block row align-items-center border p-3 rounded bg-light mb-3">
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="new_color_names[]" placeholder="Nuevo Color">
                        </div>
                        <div class="col-md-6">
                            <input type="file" class="form-control" name="new_color_images[]">
                        </div>
                        <div class="col-md-1 text-center">
                            <button type="button" class="btn btn-danger btn-sm remove-color-block" style="display:none;">X</button>
                        </div>
                    </div>
                </div>
                <button type="button" id="add_new_color" class="btn btn-info btn-sm">Añadir otro color</button>
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary mt-4 btn-lg w-100">Actualizar Producto</button>
        <a href="{{ route('admin.panel') }}" class="btn btn-secondary mt-3 w-100">Volver al Panel</a>
    </form>
</div>

{{-- FORMULARIO OCULTO PARA ELIMINAR --}}
<form id="form-delete-image" action="" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
    // Función global para manejar la eliminación
    function deleteImage(imageId) {
        if (confirm('¿Estás seguro de que deseas eliminar esta imagen?')) {
            const form = document.getElementById('form-delete-image');
            // Construimos la URL dinámicamente usando el ID. Asegúrate de que el nombre de la ruta sea correcto.
            form.action = `/admin/producto/imagen/${imageId}`; 
            form.submit();
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const categoriaSelect = document.getElementById('categoria_id');
        const camposGafas = document.getElementById('campos_gafas');
        const camposGafasSol = document.getElementById('campos_gafas_sol');
        const camposLentillas = document.getElementById('campos_lentillas');
        const camposImagenesGenerales = document.getElementById('campos_imagenes_generales');
        const ofertaCheckbox = document.getElementById('oferta');
        const precioOfertaGroup = document.getElementById('precio_oferta_group');

        function toggleCampos() {
            const texto = categoriaSelect.options[categoriaSelect.selectedIndex].text.toLowerCase();
            const esGafa = texto.includes('gafas') || texto.includes('vista') || texto.includes('sol');
            const esSol = texto.includes('sol');
            const esLentilla = texto.includes('lentes de contacto') || texto.includes('lentillas');

            camposGafas.style.display = esGafa ? 'block' : 'none';
            disableInputs(camposGafas, !esGafa);

            camposGafasSol.style.display = esSol ? 'block' : 'none';
            const inputsSol = camposGafasSol.querySelectorAll('input');
            inputsSol.forEach(i => esSol ? i.removeAttribute('disabled') : i.setAttribute('disabled', 'disabled'));

            camposImagenesGenerales.style.display = !esLentilla ? 'block' : 'none';
            disableInputs(camposImagenesGenerales, esLentilla);

            camposLentillas.style.display = esLentilla ? 'block' : 'none';
            disableInputs(camposLentillas, !esLentilla);
        }

        function disableInputs(container, shouldDisable) {
            const inputs = container.querySelectorAll('input, select, textarea, button');
            inputs.forEach(input => {
                if (shouldDisable) {
                    input.setAttribute('disabled', 'disabled');
                } else {
                    input.removeAttribute('disabled');
                }
            });
        }

        categoriaSelect.addEventListener('change', toggleCampos);
        ofertaCheckbox.addEventListener('change', () => {
            precioOfertaGroup.style.display = ofertaCheckbox.checked ? 'block' : 'none';
        });
        
        toggleCampos();

        document.getElementById('add_new_color').addEventListener('click', function() {
            const container = document.getElementById('new_colors_container');
            const block = container.querySelector('.new-color-block').cloneNode(true);
            block.querySelectorAll('input').forEach(i => i.value = '');
            const btn = block.querySelector('.remove-color-block');
            btn.style.display = 'block';
            btn.onclick = () => block.remove();
            container.appendChild(block);
        });
    });
</script>
@endsection