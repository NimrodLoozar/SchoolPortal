<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ClassIndexRequest extends FormRequest
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
            // No specific validation needed for index, but we can add filters later
            'sort_by' => 'sometimes|in:name,students_count,subjects_count,average_grade',
            'sort_direction' => 'sometimes|in:asc,desc',
            'filter_performance' => 'sometimes|in:excellent,good,satisfactory,needs_improvement,unsatisfactory',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'sort_by' => 'sort field',
            'sort_direction' => 'sort direction',
            'filter_performance' => 'performance filter',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'sort_by.in' => 'The sort field must be one of: name, students_count, subjects_count, average_grade.',
            'sort_direction.in' => 'The sort direction must be either asc or desc.',
            'filter_performance.in' => 'The performance filter must be a valid performance level.',
        ];
    }

    /**
     * Get validated sort parameters with defaults
     */
    public function getSortBy(): string
    {
        return $this->validated()['sort_by'] ?? 'name';
    }

    /**
     * Get validated sort direction with default
     */
    public function getSortDirection(): string
    {
        return $this->validated()['sort_direction'] ?? 'asc';
    }

    /**
     * Get validated performance filter
     */
    public function getPerformanceFilter(): ?string
    {
        return $this->validated()['filter_performance'] ?? null;
    }
}
