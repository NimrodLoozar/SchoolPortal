<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;

class ClassShowRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->role === 'Owner';
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'class' => 'required|string|exists:students,class',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Get the class from route parameter
        $this->merge([
            'class' => $this->route('class'),
        ]);
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'class' => 'class name',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'class.required' => 'The class name is required.',
            'class.exists' => 'The specified class does not exist.',
        ];
    }

    /**
     * Get the validated class name
     */
    public function getClassName(): string
    {
        return $this->validated()['class'];
    }

    /**
     * Check if the class has active students
     */
    public function hasActiveStudents(): bool
    {
        return Student::where('class', $this->getClassName())
            ->where('is_active', true)
            ->exists();
    }
}
