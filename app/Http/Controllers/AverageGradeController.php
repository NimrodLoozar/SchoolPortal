<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Subject;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AverageGradeController extends Controller
{
    /**
     * Display the average grades for all students by subject.
     */
    public function index()
    {
        // Only owners can access this page
        if (Auth::user()->role !== 'Owner') {
            abort(403, 'Unauthorized action.');
        }

        // Get all subjects with their average grades
        $subjectAverages = Subject::select('subjects.id', 'subjects.name', 'subjects.code')
            ->leftJoin('grades', 'subjects.id', '=', 'grades.subject_id')
            ->leftJoin('students', 'grades.student_id', '=', 'students.id')
            ->where('subjects.is_active', true)
            ->where('grades.is_active', true)
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

        // Get overall statistics
        $overallStats = [
            'total_subjects' => Subject::where('is_active', true)->count(),
            'total_students' => Student::where('is_active', true)->count(),
            'total_grades' => Grade::where('is_active', true)->count(),
            'overall_average' => Grade::where('is_active', true)->avg('grade') ?? 0,
        ];

        // Get grade distribution
        $gradeDistribution = Grade::select('grade', DB::raw('COUNT(*) as count'))
            ->where('is_active', true)
            ->groupBy('grade')
            ->orderBy('grade', 'desc')
            ->get();

        return view('grades.average-grades', compact('subjectAverages', 'overallStats', 'gradeDistribution'));
    }

    /**
     * Show detailed view for a specific subject
     */
    public function show(Subject $subject)
    {
        // Only owners can access this page
        if (Auth::user()->role !== 'Owner') {
            abort(403, 'Unauthorized action.');
        }

        // Get all students with their grades for this subject
        $studentsWithGrades = Student::select('students.*')
            ->join('grades', 'students.id', '=', 'grades.student_id')
            ->where('students.is_active', true)
            ->where('grades.subject_id', $subject->id)
            ->where('grades.is_active', true)
            ->with(['user', 'grades' => function ($query) use ($subject) {
                $query->where('subject_id', $subject->id)
                    ->where('is_active', true)
                    ->with('teacher.user');
            }])
            ->get();

        // Calculate statistics for this subject
        $subjectStats = [
            'total_students' => $studentsWithGrades->count(),
            'total_grades' => Grade::where('subject_id', $subject->id)->where('is_active', true)->count(),
            'average_grade' => Grade::where('subject_id', $subject->id)->where('is_active', true)->avg('grade') ?? 0,
            'highest_grade' => Grade::where('subject_id', $subject->id)->where('is_active', true)->max('grade') ?? 0,
            'lowest_grade' => Grade::where('subject_id', $subject->id)->where('is_active', true)->min('grade') ?? 0,
        ];

        return view('grades.subject-details', compact('subject', 'studentsWithGrades', 'subjectStats'));
    }
}
