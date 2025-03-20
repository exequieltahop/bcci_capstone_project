<?php

namespace App\Http\Controllers;

use App\Classes\LeaveCalculatorHelper;
use App\Classes\Semaphore;
use App\Enums\RoleEnum;
use App\Enums\StatusEnum;
use App\Models\EmployeeLeaveInformation;
use App\Models\Entry;
use App\Models\Leave;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $leaveCredits = EmployeeLeaveInformation::with('leaveType')->where('user_id', auth()->id())->get();
        $leaves = Leave::where('user_id', auth()->id())->with('user.employmentDetail')->paginate(10);
        return view('leaves.index', compact('leaves', 'leaveCredits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $leaveCredits = EmployeeLeaveInformation::with('leaveType')->where('user_id', auth()->id())->get();
        return view('leaves.create', compact('leaveCredits'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'leave_type' => 'required',
            'date_from' => 'required|date|lte:date_to',
            'date_to' => 'required|date|gte:date_from',
            'type' => 'required',
            'reason' => 'required'
        ]);

        $leaveCredit = EmployeeLeaveInformation::where('leave_type_id', $request->leave_type)->where('user_id', auth()->id())->first();

        if (!$leaveCredit) {
            return back()->withErrors(['leave_type' => "Employee is not eligible for this leave type."])->withInput();
        }

        if ($leaveCredit->balance < 1) {
            return back()->withErrors(['leave_type' => "No remaining leave credits."])->withInput();
        }

        // Initialize the starting date
        $date_from = \Carbon\Carbon::parse($request->date_from);
        $date_to = \Carbon\Carbon::parse($request->date_to);
        $currentDate = $date_from;
        // Loop through each date in the range

        while ($currentDate->lte($date_to) && ($leaveCredit->balance >= 1)) {
            Leave::create([
                'user_id' => auth()->id(),
                'leave_type_id' => $request->leave_type,
                'date' => $currentDate->format('Y-m-d'),
                'type' => $request->type,
                'reason' => $request->reason,
                'total_credit' => $request->type
            ]);

            // Move to the next date
            $currentDate->addDay();
            $leaveCredit->update([
                'balance' => $leaveCredit->balance - 1
            ]);

            $leaveCredit->refresh();
        }

        $admin = User::whereHas('role', function ($query) {
            $query->where('name', RoleEnum::ADMIN);
        })->first();

        $employee = auth()->user();

        Semaphore::send($admin->contact_number, "Good day Administrator, {$employee->fullName} has filed a leave. Please check the employee portal to view it. Thank you!");

        return redirect(route('leaves.index'));
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function cancelPage(Leave $leave)
    {
        request()->session()->put('previous_url', url()->previous());
        return view('leaves.cancel', compact('leave'));
    }

    public function cancelOperation(Request $request, Leave $leave)
    {
        $data = ['remarks' => $request->remarks];

        if (auth()->id() == $leave->created_by) {
            $data['status'] = StatusEnum::CANCELLED->value;
            $data['is_mgr_approval_status'] = StatusEnum::CANCELLED->value;
            $data['is_sp_approval_status'] = StatusEnum::CANCELLED->value;
        }

        if (auth()->user()->role->name == RoleEnum::ADMIN->value || auth()->user()->can_approve) {
            $data['is_mgr_approval_status'] = StatusEnum::REJECTED->value;
            $data['is_sp_approval_status'] = StatusEnum::REJECTED->value;
        }

        if (auth()->id() == $leave->user->employmentDetail->manager_id) {
            $data['is_mgr_approval_status'] = StatusEnum::REJECTED->value;
        }

        if (auth()->id() == $leave->user->employmentDetail->supervisor_id) {
            $data['is_sp_approval_status'] = StatusEnum::REJECTED->value;
        }

        $leave->update($data);
        $leave->refresh();

        if ($leave->is_mgr_approval_status == StatusEnum::REJECTED->value && $leave->is_sp_approval_status == StatusEnum::REJECTED->value) {
            $leave->update([
                'status' => StatusEnum::REJECTED->value
            ]);
        }

        $employee = User::find($leave->created_by);
        Semaphore::send($employee->contact_number, "Hello {$employee->fullName}, your filed leave has been {$leave->status}. Please check the employee portal to view it. Thank you!");

        if (auth()->id() == $leave->created_by) {
            return redirect(route('leaves.index'));
        }

        $previousUrl = $request->session()->get('previous_url');
        if ($previousUrl) return redirect($previousUrl);

        return redirect(route('employees.leaves', ['employee_id' => $leave->created_by]));
    }

    public function approveOperation(Leave $leave)
    {
        $this->processLeaveApproval($leave);

        return redirect()->back();
    }

    public function approval()
    {
        $leaves = Leave::with('user.employmentDetail')->where('status', StatusEnum::PENDING)->paginate(10);
        return view('leaves.approval', compact('leaves'));
    }

    private function processLeaveApproval(Leave $leave)
    {
        $data = [];

        if (auth()->user()->role->name == RoleEnum::ADMIN->value || auth()->user()->can_approve) {
            $data['is_mgr_approval_status'] = StatusEnum::APPROVED->value;
            $data['is_sp_approval_status'] = StatusEnum::APPROVED->value;
        }

        if (auth()->id() == $leave->user->employmentDetail->manager_id) {
            $data['is_mgr_approval_status'] = StatusEnum::APPROVED->value;
        }

        if (auth()->id() == $leave->user->employmentDetail->supervisor_id) {
            $data['is_sp_approval_status'] = StatusEnum::APPROVED->value;
        }

        $leave->update($data);
        $leave->refresh();

        if ($leave->is_mgr_approval_status == StatusEnum::APPROVED->value && $leave->is_sp_approval_status == StatusEnum::APPROVED->value) {
            $leave->update([
                'status' => StatusEnum::APPROVED->value
            ]);

            $leaveCredit = EmployeeLeaveInformation::where([
                'user_id' => $leave->created_by,
                'leave_type_id' => $leave->leave_type_id
            ])->first();

            $leaveCredit->update([
                'balance' => ($leaveCredit->balance - $leave->total_credit)
            ]);

            $clockIn = Carbon::createFromFormat('Y-m-d', $leave->date);
            $clockIn->hour = (int) config('app.clock_in');
            $clockIn->minute = (int) 0;
            $clockIn->second = (int) 0;

            $clockOut = Carbon::createFromFormat('Y-m-d', $leave->date);
            $clockOut->hour = (int) config('app.clock_out');
            $clockOut->minute = (int) 0;
            $clockOut->second = (int) 0;

            Entry::create([
                'user_id'  => $leave->created_by,
                'clock_in' => $clockIn,
                'clock_out' => $clockOut
            ]);
        }

        $employee = User::find($leave->created_by);
        Semaphore::send($employee->contact_number, "Hello {$employee->fullName}, your filed leave has been {$leave->status}. Please check the employee portal to view it. Thank you!");
    }

    public function bulkApprove(Request $request)
    {
        if (!$request->has('leaves')) return back();

        foreach ($request->leaves as $leaveId) {
            $leave = Leave::find($leaveId);

            if (!$leave) continue;

            $this->processLeaveApproval($leave);
        }

        return redirect()->back();
    }
}
