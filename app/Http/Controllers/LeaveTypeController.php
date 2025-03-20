<?php

namespace App\Http\Controllers;

use App\Models\LeaveType;
use Illuminate\Http\Request;

class LeaveTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $leaveTypes = LeaveType::paginate(10);
        return view('leave_types.index', compact('leaveTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('leave_types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:leave_types,name,except,deleted_at',
            'is_paid' => 'required'
        ]);

        LeaveType::create(['name' => $request->name, 'is_paid' => $request->is_paid == 'paid' ? 1 : 0]);

        return redirect(route('leave-types.index'));
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
    public function edit(LeaveType $leaveType)
    {
        return view('leave_types.update', compact('leaveType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LeaveType $leaveType)
    {
        $request->validate([
            'name' => 'required|unique:leave_types,name,except,deleted_at',
            'is_paid' => 'required'
        ]);
        $leaveType->update(['name' => $request->name, 'is_paid' => $request->is_paid == 'paid' ? 1 : 0]);

        return redirect(route('leave-types.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LeaveType $leaveType)
    {
        $leaveType->delete();
        return back();
    }
}
