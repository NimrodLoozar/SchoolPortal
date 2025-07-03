<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Grade extends Model
{
    /** @use HasFactory<\Database\Factories\GradeFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_id',
        'subject_id',
        'teacher_id',
        'grade',
        'description',
        'graded_at',
        'is_active',
        'comment',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'grade' => 'integer',
            'graded_at' => 'date',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the student that owns the grade.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the subject that owns the grade.
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Get the teacher that owns the grade.
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Get the grade performance level.
     */
    public function getPerformanceLevelAttribute(): string
    {
        return match($this->grade) {
            5 => 'Excellent',
            4 => 'Good',
            3 => 'Satisfactory',
            2 => 'Needs Improvement',
            1 => 'Unsatisfactory',
            default => 'Unknown'
        };
    }

    /**
     * Scope a query to only include passing grades.
     */
    public function scopePassing($query)
    {
        return $query->where('grade', '>=', 2);
    }

    /**
     * Scope a query to only include failing grades.
     */
    public function scopeFailing($query)
    {
        return $query->where('grade', '=', 1);
    }

    /**
     * Scope a query to only include active grades.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
