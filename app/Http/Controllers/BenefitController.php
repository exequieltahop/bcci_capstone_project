<?php

namespace App\Http\Controllers;

use App\Models\Benefit;
use Illuminate\Http\Request;

class BenefitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $benefits = Benefit::paginate(10);
        return view('benefits.index', compact('benefits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('benefits.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:benefits,name,except,deleted_at'
        ]);

        Benefit::create(['name' => $request->name]);

        return redirect(route('benefits.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Benefit $benefit)
    {
        return view('benefits.update', compact('benefit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Benefit $benefit)
    {
        $benefit->update(['name' => $request->name]);

        return redirect(route('benefits.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Benefit $benefit)
    {
        $benefit->delete();
        return back();
    }
}
