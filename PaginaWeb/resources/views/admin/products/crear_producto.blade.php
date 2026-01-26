@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Crear Producto</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.producto.guardar') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Categoría --}}
        <div class="form-group">
            <label for="categoria_id">Categoría</label>
            <select class="form-control" name="categoria_id" id="categoria_id" required>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                @endforeach
            </select>
        </div>

        {{-- Modelo --}}
        <div class="form-group">
            <label for="modelo">Modelo</label>
            <input type="text" class="form-control" name="modelo" id="modelo" required>
        </div>

        {{-- Marca --}}
        <div class="form-group">
            <label for="marca">Marca</label>
            <input type="text" class="form-control" name="marca" id="marca" required>
        </div>

        {{-- ================= GAFAS ================= --}}
        <div id="campos_gafas" style="display:none;">

            {{-- Género --}}
            <div class="form-group">
                <label for="genero">Género</label>
                <select class="form-control" name="genero" id="genero">
                    <option value="Hombre">Hombre</option>
                    <option value="Mujer">Mujer</option>
                    <option value="Unisex">Unisex</option>
                    <option value="Infantil">Infantil</option>
                </select>
            </div>

            {{-- Tamaño --}}
            <div class="form-group">
                <label for="tamano">Tamaño</label>
                <input type="text" class="form-control" name="tamano" id="tamano">
            </div>

            {{-- Color Montura --}}
            <div class="form-group">
                <label for="color_montura">Color de Montura</label>
                <input type="text" class="form-control" name="color_montura" id="color_montura">
            </div>

            {{-- Material Montura --}}
            <div class="form-group">
                <label for="material_montura">Material de Montura</label>
                <input type="text" class="form-control" name="material_montura" id="material_montura">
            </div>

            {{-- ===== SOLO GAFAS DE SOL ===== --}}
            <div id="campos_gafas_sol" style="display:none;">

                <div class="form-group">
                    <label for="color_cristal">Color de Cristal</label>
                    <input type="text" class="form-control" name="color_cristal" id="color_cristal">
                </div>

                <div class="form-group">
                    <label for="tipo_cristal">Tipo de Cristal</label>
                    <input type="text" class="form-control" name="tipo_cristal" id="tipo_cristal">
                </div>

            </div>
        </div>

        {{-- ================= LENTES DE CONTACTO ================= --}}
        <div id="campos_lentillas" style="display:none;">
            <div class="form-group">
                <label for="tipo_lentilla">Tipo de Lentilla</label>
                <select class="form-control" name="tipo_lentilla" id="tipo_lentilla">
                    <option value="">Seleccione un tipo</option>
                    <option value="esferica">Esférica</option>
                    <option value="torica">Tórica</option>
                    <option value="multifocal">Multifocal</option>
                </select>
            </div>
        </div>

        {{-- Precio --}}
        <div class="form-group">
            <label for="precio">Precio</label>
            <input type="number" step="0.01" class="form-control" name="precio" id="precio" required>
        </div>

        {{-- Precio Oferta --}}
        <div class="form-group">
            <label for="precio_oferta">Precio de Oferta</label>
            <input type="number" step="0.01" class="form-control" name="precio_oferta" id="precio_oferta">
        </div>

        {{-- Slug --}}
        <div class="form-group">
            <label for="slug">Slug</label>
            <input type="text" class="form-control" name="slug" id="slug" required>
        </div>

        {{-- Descripción --}}
        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea class="form-control" name="descripcion" id="descripcion" rows="3"></textarea>
        </div>

        {{-- Información Adicional --}}
        <div class="form-group">
            <label for="informacion_adicional">Información Adicional</label>
            <textarea class="form-control" name="informacion_adicional" id="informacion_adicional" rows="3"></textarea>
        </div>

        {{-- Stock --}}
        <div class="form-group">
            <label for="stock">Stock</label>
            <input type="number" class="form-control" name="stock" id="stock" value="0" required>
        </div>

        {{-- Activo --}}
        <div class="form-group">
            <label for="activo">Activo</label>
            <select class="form-control" name="activo" id="activo" required>
                <option value="1" selected>Sí</option>
                <option value="0">No</option>
            </select>
        </div>

        {{-- Oferta --}}
        <div class="form-group">
            <label for="oferta">¿Está en oferta?</label>
            <select class="form-control" name="oferta" id="oferta" required>
                <option value="0" selected>No</option>
                <option value="1">Sí</option>
            </select>
        </div>

        {{-- Imagen principal --}}
        <div class="form-group mb-3">
            <label for="imagen">Imagen principal</label>
            <input type="file" class="form-control" name="imagen" id="imagen" required>
        </div>

        {{-- Imágenes adicionales --}}
        <div class="form-group mb-4">
            <label for="imagenes">Imágenes adicionales</label>
            <input type="file" class="form-control" name="imagenes[]" id="imagenes" multiple>
            <small class="form-text text-muted">
                Puedes seleccionar varias imágenes manteniendo presionada la tecla Ctrl (o Cmd en Mac).
            </small>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Guardar Producto</button>
    </form>
</div>

{{-- SCRIPT --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const categoriaSelect = document.getElementById('categoria_id');
    const camposGafas = document.getElementById('campos_gafas');
    const camposGafasSol = document.getElementById('campos_gafas_sol');
    const camposLentillas = document.getElementById('campos_lentillas');

    function toggleCampos() {
        const texto = categoriaSelect.options[categoriaSelect.selectedIndex].text.toLowerCase();

        // GAFAS (sol o graduadas)
        const esGafa = texto.includes('gafas');
        const esGafaSol = texto.includes('sol');

        camposGafas.style.display = esGafa ? 'block' : 'none';
        camposGafasSol.style.display = esGafa && esGafaSol ? 'block' : 'none';

        // LENTES DE CONTACTO
        camposLentillas.style.display = texto === 'lentes de contacto' ? 'block' : 'none';
    }

    categoriaSelect.addEventListener('change', toggleCampos);
    toggleCampos();
});
</script>
@endsection
