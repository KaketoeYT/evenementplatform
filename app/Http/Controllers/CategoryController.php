<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
        public function index() 
    {
        // withCount('events') zorgt ervoor dat $category->events_count automatisch beschikbaar is!
        $categories = Category::withCount('events')->get();

        return view('categories.index', compact('categories'));
    }

    public function show($id)
    {
        // Haal de categorie op, laad de events + hun venues, en tel het aantal events
        $category = Category::with(['events.venue'])
            ->withCount('events')
            ->findOrFail($id);

        return view('categories.show', compact('category'));
    }

    public function create()
    {
        return view('categories.create');
    }


    public function store(Request $request)
    {
        if (auth()->user()?->role !== 'admin') {
            abort(403);
        }

        // Validatie zorgt ervoor dat de error netjes onder de input verschijnt
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Category successfully created!');
    }


        public function edit($id)
    {
        if (auth()->user()?->role !== 'admin') {
            abort(403);
        }

        $category = Category::findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()?->role !== 'admin') {
            abort(403);
        }

        $category = Category::findOrFail($id);

        // ','.$id zorgt ervoor dat de huidige naam niet als 'al bezet' wordt gezien
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
        ]);

        $category->update($validated);

        return redirect()->route('categories.show', $category->id)
            ->with('success', 'Category successfully updated!');
    }

    public function destroy($id)
    {
        if (auth()->user()?->role !== 'admin') {
            abort(403);
        }

        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Category successfully deleted!');
    }
}
