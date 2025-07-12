<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use App\Models\Category;

class TodosController extends Controller
{
    public function index()
    {
        $todos = Todo::with('category')->get();
        // Fetch all categories to display in the view
        $categories = Category::with('todos')->get(); // cada categoría con sus tareas
        return view('todos.index', ['categories' => $categories]);
    }

    public function store(Request $request){

        $request->validate([
            'title' => 'required|min:3',
        ]);
    
        $todo = new Todo;
        $todo->title = $request->title;
        $todo->category_id = $request->category_id;
        $todo->save();
    
        return redirect()->route('todos')->with('success', 'Todo created successfully');
    }

    public function destroy($id){
        $todo = Todo::find($id);
        $todo->delete();
        return redirect()->route('todos')->with('success', 'Todo deleted successfully');
    }

    public function show($id){
        $todo = Todo::find($id);
        $categories = Category::all();
        return view('todos.show', ['todo' => $todo, 'categories' => $categories]);
    }

    public function update(Request $request, $id){
        $todo = Todo::find($id);
        
        $todo->title = $request->title;
        $todo->save();

        return redirect()->route('todos')->with('success', 'Todo updated successfully');
    }
    
    public function complete($id)
    {
    $todo = Todo::findOrFail($id);
    $todo->completed = true;
    $todo->save();

    return redirect()->route('todos')->with('completed', '¡Tarea completada! 🎉');
    }

    public function __construct()
    {
    $this->middleware('auth');
    }


}