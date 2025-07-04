<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Class Details') }}: {{ $classStats['class_name'] }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('classes.index') }}"
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Back to Classes') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Class Information -->
            <div class="mb-8 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                Class {{ $classStats['class_name'] }}
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Detailed class analytics and student information
                            </p>
                        </div>
                        <div class="text-right">
                            <div class="text-3xl font-bold text-blue-600 dark:text-blue-400">
                                {{ number_format($classStats['average_grade'], 2) }}
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Class Average</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="mb-8 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-2xl font-bold text-green-600 dark:text-green-400">
                            {{ $classStats['students_count'] }}
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Students</div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">
                            {{ $subjectAverages->count() }}
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Subjects</div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-2xl font-bold text-orange-600 dark:text-orange-400">
                            {{ $classStats['total_grades'] }}
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Total Grades</div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="mb-8 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Class Analytics</h3>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Subject Averages Chart -->
                        <div>
                            <h4 class="text-md font-medium text-gray-700 dark:text-gray-300 mb-2">Average Grades by
                                Subject</h4>
                            <div class="relative h-64">
                                <canvas id="subjectAveragesChart"></canvas>
                            </div>
                        </div>
                        <!-- Student Averages Chart -->
                        <div>
                            <h4 class="text-md font-medium text-gray-700 dark:text-gray-300 mb-2">Student Performance
                                Overview</h4>
                            <div class="relative h-64">
                                <canvas id="studentAveragesChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Subject Performance Table -->
            <div class="mb-8 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                        Subject Performance
                    </h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Subject
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Code
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Average Grade
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Performance
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Students
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Total Grades
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
                                @forelse($subjectAverages as $subject)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ $subject->name }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 dark:text-gray-100">
                                                {{ $subject->code }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-bold text-gray-900 dark:text-gray-100">
                                                {{ number_format($subject->average_grade, 2) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                                @if ($subject->average_grade >= 4.5) bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100
                                                @elseif($subject->average_grade >= 3.5) bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100
                                                @elseif($subject->average_grade >= 2.5) bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100
                                                @elseif($subject->average_grade >= 1.5) bg-orange-100 text-orange-800 dark:bg-orange-800 dark:text-orange-100
                                                @else bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100 @endif">
                                                @if ($subject->average_grade >= 4.5)
                                                    Excellent
                                                @elseif($subject->average_grade >= 3.5)
                                                    Good
                                                @elseif($subject->average_grade >= 2.5)
                                                    Satisfactory
                                                @elseif($subject->average_grade >= 1.5)
                                                    Needs Improvement
                                                @else
                                                    Unsatisfactory
                                                @endif
                                            </span>
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            {{ $subject->total_students }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            {{ $subject->total_grades }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6"
                                            class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                            No subjects found for this class.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Students Table -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                        Students in Class {{ $classStats['class_name'] }}
                    </h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Student
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Student Number
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Overall Average
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Performance
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Subjects
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
                                @forelse($students as $student)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <div
                                                        class="h-10 w-10 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                                                        <span
                                                            class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                                            {{ strtoupper(substr($student->user->name, 0, 2)) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                        {{ $student->user->name }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-blue-600 dark:text-blue-400">
                                                {{ $student->student_number }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-bold text-gray-900 dark:text-gray-100">
                                                {{ number_format($student->overall_average, 2) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                                @if ($student->overall_average >= 4.5) bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100
                                                @elseif($student->overall_average >= 3.5) bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100
                                                @elseif($student->overall_average >= 2.5) bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100
                                                @elseif($student->overall_average >= 1.5) bg-orange-100 text-orange-800 dark:bg-orange-800 dark:text-orange-100
                                                @else bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100 @endif">
                                                @if ($student->overall_average >= 4.5)
                                                    Excellent
                                                @elseif($student->overall_average >= 3.5)
                                                    Good
                                                @elseif($student->overall_average >= 2.5)
                                                    Satisfactory
                                                @elseif($student->overall_average >= 1.5)
                                                    Needs Improvement
                                                @else
                                                    Unsatisfactory
                                                @endif
                                            </span>
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            {{ $student->subject_averages->count() }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('classes.student', [$classStats['class_name'], $student->id]) }}"
                                                class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                                View Details
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6"
                                            class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                            No students found in this class.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Data for charts
        const subjectData = @json($subjectAverages);
        const studentData = @json($students);

        // Create charts when page loads
        document.addEventListener('DOMContentLoaded', function() {
            createSubjectAveragesChart();
            createStudentAveragesChart();
        });

        // Subject Averages Chart
        function createSubjectAveragesChart() {
            const ctx = document.getElementById('subjectAveragesChart').getContext('2d');

            const labels = subjectData.map(subject => subject.name);
            const averages = subjectData.map(subject => parseFloat(subject.average_grade));

            // Create background colors based on performance
            const backgroundColors = averages.map(avg => {
                if (avg >= 4.5) return 'rgba(34, 197, 94, 0.8)'; // Green
                if (avg >= 3.5) return 'rgba(59, 130, 246, 0.8)'; // Blue
                if (avg >= 2.5) return 'rgba(234, 179, 8, 0.8)'; // Yellow
                if (avg >= 1.5) return 'rgba(249, 115, 22, 0.8)'; // Orange
                return 'rgba(239, 68, 68, 0.8)'; // Red
            });

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Average Grade',
                        data: averages,
                        backgroundColor: backgroundColors,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 5,
                            ticks: {
                                stepSize: 0.5
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        }

        // Student Averages Chart
        function createStudentAveragesChart() {
            const ctx = document.getElementById('studentAveragesChart').getContext('2d');

            const labels = studentData.map(student => student.user.name);
            const averages = studentData.map(student => parseFloat(student.overall_average));

            // Create background colors based on performance
            const backgroundColors = averages.map(avg => {
                if (avg >= 4.5) return 'rgba(34, 197, 94, 0.8)'; // Green
                if (avg >= 3.5) return 'rgba(59, 130, 246, 0.8)'; // Blue
                if (avg >= 2.5) return 'rgba(234, 179, 8, 0.8)'; // Yellow
                if (avg >= 1.5) return 'rgba(249, 115, 22, 0.8)'; // Orange
                return 'rgba(239, 68, 68, 0.8)'; // Red
            });

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Overall Average',
                        data: averages,
                        backgroundColor: backgroundColors,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 5,
                            ticks: {
                                stepSize: 0.5
                            }
                        },
                        x: {
                            ticks: {
                                maxRotation: 45,
                                minRotation: 45
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        }
    </script>
</x-app-layout>
