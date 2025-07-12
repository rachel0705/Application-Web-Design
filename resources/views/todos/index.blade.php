@extends('app')

@section('content')

<style>
    body {
        background-color:rgb(170, 207, 255); /* cambia este color a lo que tú quieras */
    }
</style>

<div class="text-center mb-4">
    <h2 class="fw-bold text-primary">📋 Mis Tareas</h2>
    <p class="text-muted">Organiza tu día con estilo</p>
</div>

<div class="container w-50 bg-white p-4 shadow rounded">
    <div class="row mx-auto">
    <form  method="POST" action="{{route('todos')}}">
        @csrf

        <div class="mb-3 col">
        @error('title')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        @if (session('success'))
                <h6 class="alert alert-success">{{ session('success') }}</h6>
        @endif
        @if (session('completed'))
            <div class="alert alert-success fw-bold text-center" id="celebration">
                🎉 {{ session('completed') }} 🎉
            </div>

            <script>
                setTimeout(() => {
                    confetti({
                        particleCount: 100,
                        spread: 70,
                        origin: { y: 0.6 }
                    });
                }, 300); // pequeña pausa para que cargue bien
            </script>
        @endif

            <label for="title" class="form-label">Título de la tarea</label>
            <input type="text" class="form-control mb-2" name="title" id="exampleFormControlInput1" placeholder="Comprar la cena">

            <label for="category_id" class="form-label">Categoria de la tarea</label>
            <select name="category_id" class="form-select">
                @foreach ($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
            </select>
            <input type="submit" value="Crear tarea" class="btn btn-primary my-2" />
        </div>
    </form>

<div class="row">
@php
    $totalTodos = $categories->sum(fn($category) => $category->todos->count());
@endphp

<h5 class="mb-4 fw-semibold text-secondary">
    📝 Tienes {{ $totalTodos }} tarea{{ $totalTodos === 1 ? '' : 's' }} pendiente{{ $totalTodos === 1 ? '' : 's' }}.
</h5>

    @foreach ($categories as $category)
    @if ($category->todos->count() > 0)
        <h5 class="mt-4 mb-2" style="color: {{ $category->color }};">
            {{ $category->name }} ({{ $category->todos->count() }} tarea{{ $category->todos->count() === 1 ? '' : 's' }})
        </h5>

        @foreach ($category->todos as $todo)
                        <div class="col-12 mb-3">
                <div class="card shadow border-0" style="border-left: 5px solid {{ $category->color }};">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            @if ($todo->completed)
                            <h5 class="card-title mb-1 fw-bold text-decoration-line-through text-muted">
                                {{ $todo->title }}
                            </h5>
                        @else
                            <h5 class="card-title mb-1 fw-bold">
                                {{ $todo->title }}
                            </h5>
                        @endif
                            
                            <span class="badge rounded-pill" style="background-color: {{ $category->color }}; color: white;">
                                {{ $category->name }}
                            </span>
                        </div>

                        <div class="text-end">
                            <form action="{{ route('todos.complete', $todo->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-success btn-sm me-2">✔️</button>
                            </form>
                            <a href="{{ route('todos-edit', ['id' => $todo->id]) }}" class="btn btn-outline-primary btn-sm me-2">
                                ✏️
                            </a>
                            <form action="{{ route('todos-destroy', [$todo->id]) }}" method="POST" style="display:inline;">
                                @method('DELETE')
                                @csrf
                                <button class="btn btn-danger btn-sm">🗑️</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        @endforeach
    @endif
@endforeach

    </div>
</div>
@endsection