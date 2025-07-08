<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;

class ClassStudentRequest extends FormRequest
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
            'student' => 'required|integer|exists:students,id',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Get the class and student from route parameters
        $this->merge([
            'class' => $this->route('class'),
            'student' => $this->route('student'),
        ]);
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            // Check if the student belongs to the specified class
            if ($this->filled(['class', 'student'])) {
                $student = Student::where('id', $this->input('student'))
                    ->where('class', $this->input('class'))
                    ->where('is_active', true)
                    ->first();

                if (!$student) {
                    $validator->errors()->add('student', 'The student does not belong to the specified class or is not active.');
                }
            }
        });
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'class' => 'class name',
            'student' => 'student ID',
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
            'student.required' => 'The student ID is required.',
            'student.integer' => 'The student ID must be an integer.',
            'student.exists' => 'The specified student does not exist.',
        ];
    }

    /**
     * Get the validated class name.
     */
    public function getClassName(): string
    {
        return $this->validated()['class'];
    }

    /**
     * Get the validated student ID.
     */
    public function getStudentId(): int
    {
        return $this->validated()['student'];
    }
}
