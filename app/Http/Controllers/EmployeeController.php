<?php

namespace App\Http\Controllers;

use App\Enums\RoleEnum;
use App\Http\Requests\EmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Benefit;
use App\Models\Category;
use App\Models\Deduction;
use App\Models\EmployeeLeaveInformation;
use App\Models\EmploymentDetail;
use App\Models\Leave;
use App\Models\PayrollInformation;
use App\Models\Position;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = User::with(['role', 'employmentDetail'])
            // ->whereHas('role', fn($query) => $query->whereNot('name', RoleEnum::ADMIN))
            ->paginate(10);

        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        $positions = Position::with('employmentDetails.user')->get();
        $categories = Category::with('positions')->get();

        return view('employees.create', compact('positions', 'categories'));
    }

    public function store(EmployeeRequest $request)
    {
        $user = User::create([
            ...$request->only([
                'first_name',
                'middle_name',
                'last_name',
                'gender',
                'marital_status',
                'date_of_birth',
                'contact_number',
                'address',
                'email',
                'can_approve',
                'employee_code'
            ]),
            'role_id' => Role::where('name', RoleEnum::EMPLOYEE)->first()?->id,
            'password' => bcrypt('bcci_1234')
        ]);

        EmploymentDetail::create([
            ...$request->only([
                'department',
                'employment_status',
                'date_hired',
                'date_regularized',
            ]),
            'position_id' => $request->position,
            'manager_id' => $request->manager,
            'supervisor_id' => $request->supervisor,
            'user_id' => $user->id,
        ]);

        PayrollInformation::updateOrCreate(
            ['user_id' => $user->id],
            $request->only(['basic_salary','pay_mode','payment_method', 'bank_account']),
        );

        return redirect(route('employees.index'));
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        $user->load('role', 'employmentDetail', 'payrollInformation');

        return view('employees.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $user->load('role', 'employmentDetail', 'payrollInformation');
        $positions = Position::with('employmentDetails.user')->get();
        $categories = Category::with('positions')->get();

        return view('employees.edit', compact('user', 'positions', 'categories'));
    }

    public function update(UpdateEmployeeRequest $request)
    {
        $user = User::findOrFail($request->employee);

        $user->update($request->only([
            'first_name',
            'middle_name',
            'last_name',
            'gender',
            'marital_status',
            'date_of_birth',
            'contact_number',
            'address',
            'can_approve',
            'employee_code'
        ]));

        $user->employmentDetail->update([
            ...$request->only([
                'department',
                'employment_status',
                'date_hired',
                'date_regularized',
            ]),
            'position_id' => $request->position,
            'manager_id' => $request->manager,
            'supervisor_id' => $request->supervisor,
        ]);

        PayrollInformation::updateOrCreate(
            ['user_id' => $user->id],
            $request->only(['basic_salary','pay_mode','payment_method', 'bank_account']),
        );

        return redirect(route('employees.index'));
    }

    public function destroy($id)
    {
        User::findOrFail($id)?->delete();
        return back();
    }

    public function leaves($id)
    {
        $user = User::findOrFail($id);

        $leaves = Leave::where('user_id', $id)->paginate(10);
        $employeeLeaves = EmployeeLeaveInformation::where('user_id', $id)->paginate(10);

        return view('employees.subview.leaves', compact('leaves', 'user', 'employeeLeaves'));
    }

    public function deductions($id)
    {
        $user = User::findOrFail($id);

        $deductions = Deduction::where('user_id', $id)->paginate(10);

        return view('employees.subview.deductions', compact('deductions', 'user'));
    }

    public function deduction_create(User $employee)
    {
        $benefits = Benefit::get();

        return view('deductions.create', compact('benefits', 'employee'));
    }

    public function deduction_edit(User $employee, Deduction $deduction)
    {
        $benefits = Benefit::get();

        return view('deductions.update', compact('benefits', 'employee', 'deduction'));
    }

    public function biometricRegister(Request $request)
    {
        $user = User::where('employee_code', $request->employee_code)->first();

        if(!$user) {
            return response()->json(['success' => false, 'message' => 'Employee not found!']);
        }

        $user->update(['fingerprint' => $request->fingerprint]);

        return response()->json(['success' => true]);
    }
}
