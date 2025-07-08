<?php

namespace App\DTOs;

use Illuminate\Support\Collection;

class ClassOverviewCollectionDTO
{
    /**
     * @param Collection<ClassOverviewDTO> $classes
     */
    public function __construct(
        public readonly Collection $classes
    ) {}

    /**
     * Get total number of classes
     */
    public function getTotalClasses(): int
    {
        return $this->classes->count();
    }

    /**
     * Get total number of students across all classes
     */
    public function getTotalStudents(): int
    {
        return $this->classes->sum('students_count');
    }

    /**
     * Get overall average grade across all classes
     */
    public function getOverallAverageGrade(): float
    {
        return $this->classes->avg('average_grade');
    }

    /**
     * Get formatted overall average grade
     */
    public function getFormattedOverallAverageGrade(): string
    {
        return number_format($this->getOverallAverageGrade(), 2);
    }

    /**
     * Get data formatted for Chart.js
     */
    public function getChartData(): array
    {
        return $this->classes->map(function (ClassOverviewDTO $class) {
            return $class->toArray();
        })->toArray();
    }

    /**
     * Convert to array for view
     */
    public function toArray(): array
    {
        return [
            'classes' => $this->classes,
            'total_classes' => $this->getTotalClasses(),
            'total_students' => $this->getTotalStudents(),
            'overall_average_grade' => $this->getOverallAverageGrade(),
            'formatted_overall_average_grade' => $this->getFormattedOverallAverageGrade(),
            'chart_data' => $this->getChartData()
        ];
    }
}
