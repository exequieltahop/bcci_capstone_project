<?php

namespace App\Http\Requests\Overtime;

use App\Models\{Entry, Overtime};
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'overtime_id' => ['required', 'integer', 'exists:overtimes,id'],
            'entry_id'    => ['required', 'integer', 'exists:entries,id'],
            'time_start'  => ['required', 'string', 'regex:/^([01]\d|2[0-3]):([0-5]\d)$/'],
            'time_end'    => ['required', 'string', 'regex:/^([01]\d|2[0-3]):([0-5]\d)$/'],
            'purpose'     => ['required', 'string'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (empty($this->time_start) || empty($this->time_end)) {
                return false;
            }

            // Validated submitted time_start & time_end if within the entry
            $entry = Entry::find($this->entry_id);

            [$startHour, $startMinute] = explode(':', $this->time_start);
            [$endHour, $endMinute]     = explode(':', $this->time_end);

            $expectedTimeStart = $entry->clock_in->copy()->setHour((int) config('app.clock_out'))->startOfHour();
            $timeStart         = $entry->clock_in->copy()->setTime($startHour, $startMinute);
            $timeEnd           = $entry->clock_out->copy()->setTime($endHour, $endMinute);

            if ($timeStart->lessThan($expectedTimeStart) || $timeStart->greaterThan($entry->clock_out)) {
                $validator->errors()->add('invalid_time_start', __('Invalid time start.'));
            }

            if ($timeEnd->lessThan($expectedTimeStart) || $timeEnd->greaterThan($entry->clock_out)) {
                $validator->errors()->add('invalid_time_end', __('Invalid time end.'));
            }

            // Validated submitted OT already exist
            $overtime = Overtime::whereDate('time_start', $entry->clock_in)->first();

            if ($overtime && $overtime->id != $this->overtime_id) {
                $validator->errors()->add('duplicate_ot', __('Overtime has been filed already.'));
            }
        });
    }
}
