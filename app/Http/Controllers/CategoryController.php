<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::paginate(10);
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name,NULL,deleted_at'
        ]);

        Category::create([
            'name' => $request->name
        ]);

        return redirect(route('categories.index'));
    }

    public function edit(Category $category)
    {
        return view('categories.update', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|unique:categories,name,' . $category->id . ',id,deleted_at,NULL',
        ]);

        $category->update(['name' => $request->name]);

        return redirect(route('categories.index'));
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->back();
    }
}
