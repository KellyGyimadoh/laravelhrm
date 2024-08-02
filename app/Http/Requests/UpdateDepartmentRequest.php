<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\User;


use Illuminate\Validation\Rules\File;

class UpdateDepartmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Ensure authorization returns true if you want to allow access
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'departmenthead' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    // Find the user by the first name
                    $user = User::where('firstname', $value)->first();

                    if (!$user) {
                        return $fail('The selected department head does not exist.');
                    }

                    // Check if the user belongs to the department being updated
                    if ($user->department_id !== $this->route('department')->id) {
                        return $fail('The selected department head does not belong to this department.');
                    }
                },
            ],
            'description' => ['required', 'string'],
            'email' => ['required', 'email'],
            'image' => [File::types(['png', 'jpg', 'jpeg'])->max(2048)], // max size 2MB
        ];
    }

    /**
     * Custom messages for validation errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'departmenthead.required' => 'Please select a department head.',
            'departmenthead.string' => 'The department head name must be a valid string.',
        ];
    }
}
