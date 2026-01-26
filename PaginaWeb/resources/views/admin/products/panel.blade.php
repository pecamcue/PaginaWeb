@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1>Panel de Administración</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        <h3>Productos</h3>
        <a href="{{ route('admin.producto.crear') }}" class="btn btn-primary mb-3">Crear Producto</a>
        
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Modelo</th>
                    <th>Marca</th>
                    <th>Precio</th>
                    <th>Categoría</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($productos as $producto)
                    <tr>
                        <td>
                            @if ($producto->imagen)
                                <img src="{{ url('storage/' . $producto->imagen) }}" alt="Imagen del producto" width="80" height="auto">
                            @else
                                <span class="text-muted">Sin imagen</span>
                            @endif
                        </td>
                        <td>{{ $producto->modelo }}</td>
                        <td>{{ $producto->marca }}</td>
                        <td>{{ $producto->precio }}</td>
                        <td>{{ $producto->categoria->nombre }}</td>
                        <td>
                            <a href="{{ route('admin.producto.editar', $producto->id) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('admin.producto.eliminar', $producto->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
