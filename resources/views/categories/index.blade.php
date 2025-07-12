@extends('app')

@section('content')

<style>
    body {
        background-color:rgb(170, 207, 255);
    }
</style>

<div class="container w-50 bg-white p-4 rounded shadow">
    <div class="text-center mb-4">
        <h2 class="fw-bold text-primary">🎨 Categorías</h2>
        <p class="text-muted">Crea y organiza tus tareas por color y nombre</p>
    </div>

    <form method="POST" action="{{ route('categories.store') }}" class="mb-4">
        @csrf

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        @error('color')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <div class="mb-3">
            <label for="name" class="form-label">Nombre de la categoría</label>
            <input type="text" class="form-control" name="name" placeholder="Hogar">
        </div>

        <div class="mb-3">
            <label for="color" class="form-label">Escoge un color para la categoría</label>
            <input type="color" class="form-control form-control-color" name="color" value="#563d7c" title="Choose your color">
        </div>

        <button type="submit" class="btn btn-primary w-100">
            ➕ Crear categoría
        </button>
    </form>

    <div class="row">
        @foreach ($categories as $category)
            <div class="col-12 mb-3">
                <div class="card shadow-sm border-start border-5" style="border-color: {{ $category->color }}">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-3">
                            <span class="rounded-circle" style="background-color: {{ $category->color }}; width: 20px; height: 20px;"></span>
                            <a class="text-decoration-none text-dark fw-semibold" href="{{ route('categories.show', $category->id) }}">
                                {{ $category->name }}
                            </a>
                        </div>

                        <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modal{{$category->id}}">
                            🗑️
                        </button>
                    </div>
                </div>
            </div>

            <!-- MODAL -->
            <div class="modal fade" id="modal{{$category->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Eliminar categoría</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        Al eliminar la categoría <strong>{{ $category->name }}</strong> se eliminarán todas las tareas asignadas.
                        <br>¿Estás segura de eliminarla?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-danger">Sí, eliminar</button>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection
