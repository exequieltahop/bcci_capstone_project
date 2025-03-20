<?php

namespace App\Http\Requests\Overtime;

use Illuminate\Foundation\Http\FormRequest;

class ApprovedRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'comment' => ['nullable', 'string'],
        ];
    }
}
