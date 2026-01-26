@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1>¿Estás seguro de eliminar este producto?</h1>
        
        <form action="{{ route('admin.producto.eliminar', $producto->id) }}" method="POST">
            @csrf
            @method('DELETE')
            
            <button type="submit" class="btn btn-danger">Eliminar</button>
            <a href="{{ route('admin.panel') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection
