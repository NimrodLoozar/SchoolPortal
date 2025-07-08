<?php

namespace App\DTOs;

class ClassOverviewDTO
{
    public function __construct(
        public readonly string $class,
        public readonly int $students_count,
        public readonly int $subjects_count,
        public readonly float $average_grade,
        public readonly string $performance_level,
        public readonly string $performance_color_class
    ) {}

    /**
     * Get the performance level based on average grade
     */
    public static function getPerformanceLevel(float $average_grade): string
    {
        if ($average_grade >= 4.5) return 'Excellent';
        if ($average_grade >= 3.5) return 'Good';
        if ($average_grade >= 2.5) return 'Satisfactory';
        if ($average_grade >= 1.5) return 'Needs Improvement';
        return 'Unsatisfactory';
    }

    /**
     * Get the Tailwind CSS color classes for performance level
     */
    public static function getPerformanceColorClass(float $average_grade): string
    {
        if ($average_grade >= 4.5) return 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100';
        if ($average_grade >= 3.5) return 'bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100';
        if ($average_grade >= 2.5) return 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100';
        if ($average_grade >= 1.5) return 'bg-orange-100 text-orange-800 dark:bg-orange-800 dark:text-orange-100';
        return 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100';
    }

    /**
     * Create DTO instance from class data
     */
    public static function fromClassData(object $classData): self
    {
        return new self(
            class: $classData->class,
            students_count: $classData->students_count,
            subjects_count: $classData->subjects_count,
            average_grade: $classData->average_grade,
            performance_level: self::getPerformanceLevel($classData->average_grade),
            performance_color_class: self::getPerformanceColorClass($classData->average_grade)
        );
    }

    /**
     * Get class initials for display
     */
    public function getClassInitials(): string
    {
        return strtoupper(substr($this->class, 0, 2));
    }

    /**
     * Get formatted average grade
     */
    public function getFormattedAverageGrade(): string
    {
        return number_format($this->average_grade, 2);
    }

    /**
     * Convert to array for JSON serialization (for charts)
     */
    public function toArray(): array
    {
        return [
            'class' => $this->class,
            'students_count' => $this->students_count,
            'subjects_count' => $this->subjects_count,
            'average_grade' => $this->average_grade,
            'performance_level' => $this->performance_level,
            'performance_color_class' => $this->performance_color_class
        ];
    }
}
