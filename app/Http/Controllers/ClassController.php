<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Subject;
use App\Models\Grade;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ClassController extends Controller
{
    /**
     * Display a listing of all classes
     */
    public function index()
    {
        // Only owners can access this page
        if (Auth::user()->role !== 'Owner') {
            abort(403, 'Unauthorized action.');
        }

        // Get all classes with statistics
        $classNames = Student::select('class')
            ->where('is_active', true)
            ->whereNotNull('class')
            ->groupBy('class')
            ->pluck('class');

        $classes = $classNames->map(function ($className) {
            $classData = new \stdClass();
            $classData->class = $className;

            // Get students count
            $classData->students_count = Student::where('class', $className)
                ->where('is_active', true)
                ->count();

            // Get subjects for this class
            $classData->subjects = Subject::select('subjects.*')
                ->join('grades', 'subjects.id', '=', 'grades.subject_id')
                ->join('students', 'grades.student_id', '=', 'students.id')
                ->where('students.class', $className)
                ->where('students.is_active', true)
                ->where('grades.is_active', true)
                ->where('subjects.is_active', true)
                ->distinct()
                ->get();

            $classData->subjects_count = $classData->subjects->count();

            // Calculate average grade for this class
            $classData->average_grade = Grade::join('students', 'grades.student_id', '=', 'students.id')
                ->where('students.class', $className)
                ->where('students.is_active', true)
                ->where('grades.is_active', true)
                ->avg('grades.grade') ?? 0;

            return $classData;
        });

        return view('classes.index', compact('classes'));
    }

    /**
     * Display the specified class with detailed analytics
     */
    public function show($class)
    {
        // Only owners can access this page
        if (Auth::user()->role !== 'Owner') {
            abort(403, 'Unauthorized action.');
        }

        // Get class statistics
        $classStats = [
            'class_name' => $class,
            'students_count' => Student::where('class', $class)->where('is_active', true)->count(),
            'total_grades' => Grade::join('students', 'grades.student_id', '=', 'students.id')
                ->where('students.class', $class)
                ->where('students.is_active', true)
                ->where('grades.is_active', true)
                ->count(),
            'average_grade' => Grade::join('students', 'grades.student_id', '=', 'students.id')
                ->where('students.class', $class)
                ->where('students.is_active', true)
                ->where('grades.is_active', true)
                ->avg('grades.grade') ?? 0,
        ];

        // Get subjects for this class with their averages
        $subjectAverages = Subject::select('subjects.id', 'subjects.name', 'subjects.code')
            ->join('grades', 'subjects.id', '=', 'grades.subject_id')
            ->join('students', 'grades.student_id', '=', 'students.id')
            ->where('students.class', $class)
            ->where('students.is_active', true)
            ->where('grades.is_active', true)
            ->where('subjects.is_active', true)
            ->groupBy('subjects.id', 'subjects.name', 'subjects.code')
            ->selectRaw('
                subjects.id,
                subjects.name,
                subjects.code,
                ROUND(AVG(grades.grade), 2) as average_grade,
                COUNT(grades.id) as total_grades,
                COUNT(DISTINCT students.id) as total_students
            ')
            ->orderBy('subjects.name')
            ->get();

        // Get students with their averages per subject
        $students = Student::with(['user', 'grades.subject'])
            ->where('class', $class)
            ->where('is_active', true)
            ->get()
            ->map(function ($student) {
                // Calculate average per subject for this student
                $subjectAverages = $student->grades
                    ->where('is_active', true)
                    ->groupBy('subject_id')
                    ->map(function ($grades) {
                        return [
                            'subject' => $grades->first()->subject,
                            'average_grade' => $grades->avg('grade'),
                            'total_grades' => $grades->count()
                        ];
                    });

                $student->subject_averages = $subjectAverages;
                $student->overall_average = $student->grades
                    ->where('is_active', true)
                    ->avg('grade') ?? 0;

                return $student;
            });

        return view('classes.show', compact('classStats', 'subjectAverages', 'students'));
    }

    /**
     * Display detailed information for a specific student
     */
    public function showStudent($class, $studentId)
    {
        // Only owners can access this page
        if (Auth::user()->role !== 'Owner') {
            abort(403, 'Unauthorized action.');
        }

        // Get student with all related data
        $student = Student::with(['user.contact', 'grades.subject', 'grades.teacher.user'])
            ->where('id', $studentId)
            ->where('class', $class)
            ->where('is_active', true)
            ->firstOrFail();

        // Calculate subject averages
        $subjectData = $student->grades
            ->where('is_active', true)
            ->groupBy('subject_id')
            ->map(function ($grades) {
                $subject = $grades->first()->subject;
                return [
                    'subject' => $subject,
                    'average_grade' => $grades->avg('grade'),
                    'grades' => $grades->sortByDesc('graded_at'),
                    'total_grades' => $grades->count(),
                    'highest_grade' => $grades->max('grade'),
                    'lowest_grade' => $grades->min('grade')
                ];
            })->sortBy('subject.name');

        // Overall statistics
        $studentStats = [
            'overall_average' => $student->grades->where('is_active', true)->avg('grade') ?? 0,
            'total_grades' => $student->grades->where('is_active', true)->count(),
            'total_subjects' => $subjectData->count(),
            'highest_grade' => $student->grades->where('is_active', true)->max('grade') ?? 0,
            'lowest_grade' => $student->grades->where('is_active', true)->min('grade') ?? 0,
        ];

        return view('classes.student', compact('student', 'subjectData', 'studentStats'));
    }
}
