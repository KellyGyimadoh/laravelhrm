<?php

namespace App\Http\Requests;

use Dotenv\Validator as DotenvValidator;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class StoreUserLeaveRequest extends FormRequest
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
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            redirect()->back()->withErrors($validator->errors())->withInput()
        );
    }
   /* protected function prepareForValidation()
    {
        $this->merge($this->except(['_token', '_method']));
    }
   /* protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'errors' => $errors,
            ], 422)
        );
    }
    /**protected function prepareForValidation()
    {
        $this->merge($this->except(['_token', '_method']));
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            redirect()->back()->withErrors($validator->errors())->withInput()
        );
    } */

}
