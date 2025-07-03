<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Schedule extends Model
{
    /** @use HasFactory<\Database\Factories\ScheduleFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'subject_id',
        'teacher_id',
        'room_id',
        'weekday',
        'start_time',
        'end_time',
        'group',
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
            'start_time' => 'datetime:H:i',
            'end_time' => 'datetime:H:i',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the subject that owns the schedule.
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Get the teacher that owns the schedule.
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Get the room that owns the schedule.
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Get the enrollments for the schedule.
     */
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Get the notes for the schedule.
     */
    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    /**
     * Get the students through enrollments.
     */
    public function students()
    {
        return $this->hasManyThrough(Student::class, Enrollment::class, 'schedule_id', 'id', 'id', 'student_id');
    }

    /**
     * Get the weekday names.
     */
    public static function getWeekdayNames(): array
    {
        return [
            'H' => 'Hétfő',
            'K' => 'Kedd',
            'Sze' => 'Szerda',
            'Cs' => 'Csütörtök',
            'P' => 'Péntek',
        ];
    }

    /**
     * Get the human readable weekday name.
     */
    public function getWeekdayNameAttribute(): string
    {
        return self::getWeekdayNames()[$this->weekday] ?? $this->weekday;
    }

    /**
     * Get the duration in minutes.
     */
    public function getDurationAttribute(): int
    {
        $start = \Carbon\Carbon::parse($this->start_time);
        $end = \Carbon\Carbon::parse($this->end_time);
        
        return $end->diffInMinutes($start);
    }
}
