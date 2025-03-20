<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeductionRequest;
use App\Models\Benefit;
use App\Models\Deduction;
use App\Models\User;
use Illuminate\Http\Request;

class DeductionController extends Controller
{
    public function store(DeductionRequest $request)
    {
        $deduction = Deduction::create([
            ...$request->only(['user_id', 'amount']),
            'benefit_id' => $request->benefit
        ]);

        return redirect(route('employees.deductions', ['employee_id' => $request->user_id]));
    }

    public function edit(Deduction $deduction)
    {
        $benefits = Benefit::get();

        return view('deductions.update', compact('deduction', 'benefits'));
    }

    public function update(DeductionRequest $request, Deduction $deduction)
    {
        $deduction->update([
            ...$request->only(['amount']),
            'benefit_id' => $request->benefit
        ]);

        return redirect(route('employees.deductions', ['employee_id' => $request->user_id]));
    }

    public function destroy(Deduction $deduction)
    {
        $deduction->delete();

        return back();
    }
}
