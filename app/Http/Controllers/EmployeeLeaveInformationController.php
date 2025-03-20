<?php

namespace App\Http\Controllers;

use App\Models\EmployeeLeaveInformation;
use App\Models\LeaveType;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeeLeaveInformationController extends Controller
{
    public function create()
    {
        $leaveTypes = LeaveType::get();

        return view('leave_information.create', compact('leaveTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'leave_type' => 'required',
            'balance' => 'required'
        ]);

        EmployeeLeaveInformation::create([
            'user_id' => $request->employee_id,
            'leave_type_id' => $request->leave_type,
            'balance' => $request->balance
        ]);

        return redirect(route('employees.leaves', ['employee_id' => $request->employee_id]));
    }

    public function edit(Request $request)
    {
        $leaveTypes = LeaveType::get();
        $leaveInformation = EmployeeLeaveInformation::findOrFail($request->leave_information_id);
        return view('leave_information.edit', ['leaveInformation' => $leaveInformation, 'leaveTypes' => $leaveTypes]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'leave_type' => 'required',
            'balance' => 'required'
        ]);

        $leaveInformation = EmployeeLeaveInformation::findOrFail($request->leave_information_id);
        $user = User::findOrFail($request->employee_id);

        $leaveInformation->update([
            'user_id' => $user->id,
            'leave_type_id' => $request->leave_type,
            'balance' => $request->balance
        ]);

        return redirect(route('employees.leaves', ['employee_id' => $request->employee_id]));
    }

    public function destroy(Request $request)
    {
        $leaveInformation = EmployeeLeaveInformation::where([
            'user_id' => $request->employee_id,
            'id' => $request->leave_information_id
        ])->first();


        if (!$leaveInformation) {
            abort(404);
        }

        $leaveInformation->delete();

        return redirect(route('employees.leaves', ['employee_id' => $request->employee_id]));
    }
}
