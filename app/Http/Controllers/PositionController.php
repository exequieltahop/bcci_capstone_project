<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index()
    {
        $positions = Position::paginate(10);
        return view('positions.index', compact('positions'));
    }

    public function create()
    {
        $categories = Category::get();
        return view('positions.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:positions,name,NULL,deleted_at',
            'category' => 'required'
        ]);

        Position::create([
            'name' => $request->name,
            'category_id' => $request->category
        ]);

        return redirect(route('positions.index'));
    }

    public function edit(Position $position)
    {
        $categories = Category::get();
        return view('positions.update', compact('position', 'categories'));
    }

    public function update(Request $request, Position $position)
    {
        $request->validate([
            'name' => 'required|unique:positions,name,' . $position->id . ',id,deleted_at,NULL',
            'category' => 'required'
        ]);

        $position->update(['name' => $request->name, 'category_id' => $request->category]);

        return redirect(route('positions.index'));
    }

    public function destroy(Position $position)
    {
        $position->delete();
        return redirect()->back();
    }
}
