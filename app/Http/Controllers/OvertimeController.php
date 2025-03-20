<?php

namespace App\Http\Controllers;

use App\Actions\Employee\{EmployeeApprovesOvertime, EmployeeCancelsOvertime, EmployeeFilesOvertime, EmployeeRejectsOvertime, EmployeeUpdatesOvertime};
use App\Enums\StatusEnum;
use App\Http\Requests\Overtime\{ApprovedRequest, RejectedRequest, StoreRequest, UpdateRequest};
use App\Models\{Entry, Overtime};
use Illuminate\Support\Facades\Auth;

class OvertimeController extends Controller
{
    public function index()
    {
        $statusColor = [
            'pending'   => 'blue',
            'approved'  => 'green',
            'rejected'  => 'red',
            'cancelled' => 'gray',
        ];

        $overtimes = Overtime::where('user_id', Auth::id())
            ->with([
                'employee:id',
                'employee.employmentDetail:id,user_id,manager_id,supervisor_id',
                'employee.employmentDetail.supervisor:id,first_name,last_name',
                'employee.employmentDetail.manager:id,first_name,last_name',
            ])
            ->orderBy('time_start', 'desc')
            ->paginate(10);

        return view('overtimes.index', compact('overtimes', 'statusColor'));
    }

    public function create()
    {
        $time    = sprintf('%02d:00:00', (int) config('app.clock_out'));
        $entries = Entry::where('user_id', Auth::id())
            ->whereRaw('TIME(clock_out) > ?', [$time])
            ->orderBy('clock_in', 'desc')
            ->get();

        return view('overtimes.create', compact('entries'));
    }

    public function edit(Overtime $overtime)
    {
        $time    = sprintf('%02d:00:00', (int) config('app.clock_out'));
        $entries = Entry::where('user_id', Auth::id())
            ->whereRaw('TIME(clock_out) > ?', [$time])
            ->orderBy('clock_in', 'desc')
            ->get();

        return view('overtimes.edit', compact('overtime', 'entries'));
    }

    public function approval()
    {
        $overtimes = Overtime::with([
                'employee:id,first_name,last_name',
                'employee.employmentDetail:id,user_id,manager_id,supervisor_id',
                'employee.employmentDetail.supervisor:id,first_name,last_name',
                'employee.employmentDetail.manager:id,first_name,last_name',
            ])
            ->whereHas('employee.employmentDetail', function ($query) {
                $query->where('manager_id', Auth::id())
                    ->orWhere('supervisor_id', Auth::id());
            })
            ->where('status', StatusEnum::PENDING)
            ->orderBy('time_start', 'desc')
            ->paginate(10);

        return view('overtimes.approval', compact('overtimes'));
    }

    public function store(StoreRequest $request, EmployeeFilesOvertime $fileOvertime)
    {
        $fileOvertime->execute(Auth::user(), $request->validated());

        return redirect(route('overtimes.index'));
    }

    public function update(UpdateRequest $request, Overtime $overtime, EmployeeUpdatesOvertime $updateOvertime)
    {
        $updateOvertime->execute(Auth::user(), $overtime, $request->validated());

        return redirect(route('overtimes.index'));
    }

    public function destroy(Overtime $overtime, EmployeeCancelsOvertime $cancelOvertime)
    {
        $cancelOvertime->execute($overtime);

        return redirect()->back();
    }

    public function approved(ApprovedRequest $request, Overtime $overtime, EmployeeApprovesOvertime $approveOvertime)
    {
        $approveOvertime->execute(Auth::user(), $overtime, $request->validated());

        return redirect()->back();
    }

    public function rejected(RejectedRequest $request, Overtime $overtime, EmployeeRejectsOvertime $rejectOvertime)
    {
        $rejectOvertime->execute(Auth::user(), $overtime, $request->validated());

        return redirect()->back();
    }
}
