<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserLeaveRequest extends FormRequest
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
            'status'=>['required'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', function ($attribute, $value, $fail) {
                $startDate = $this->input('start_date');
                $endDate = $value;

                if (strtotime($endDate) > strtotime($startDate . ' +30 days')) {
                    $fail('The end date must be within 30 days from the start date.');
                }
            }],
            'type' => ['required'],
        ];
    }
}
