<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodosController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Proteger todas las rutas con login
Route::middleware(['auth'])->group(function () {
    // Todos
    Route::get('/todos', [TodosController::class, 'index'])->name('todos');
    Route::post('/todos', [TodosController::class, 'store']);
    Route::delete('/todos/{id}', [TodosController::class, 'destroy'])->name('todos-destroy');
    Route::get('/todos/{id}', [TodosController::class, 'show'])->name('todos-edit');
    Route::patch('/todos/{id}', [TodosController::class, 'update'])->name('todos-update');
    Route::patch('/todos/{id}/complete', [TodosController::class, 'complete'])->name('todos.complete');

    // Categorías
    Route::resource('categories', CategoryController::class);
});

// Breeze (Auth) routes
require __DIR__.'/auth.php';


// Products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');