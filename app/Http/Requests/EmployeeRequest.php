<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // user information
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required',
            'marital_status' => 'required',
            'date_of_birth' => 'required',
            'contact_number' => 'required',
            'address' => 'required',
            'employee_code' => 'required|unique:users,employee_code',

            // employment detail
            'position' => 'required',
            'department' => 'required',
            'manager' => 'nullable',
            'supervisor' => 'nullable',
            'employment_status' => 'required',
            'date_hired' => 'required',
            'date_regularized' => 'required',

            // payroll information
            'basic_salary' => 'required',
            'pay_mode' => 'required',
            'payment_method' => 'required',
        ];
    }
}
