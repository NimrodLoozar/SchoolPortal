<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Average Grades by Subject') }}
            </h2>
            <a href="{{ route('dashboard') }}"
                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Back to Dashboard') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Overall Statistics -->
            <div class="mb-8 grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                            {{ $overallStats['total_subjects'] }}
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Active Subjects</div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-2xl font-bold text-green-600 dark:text-green-400">
                            {{ $overallStats['total_students'] }}
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Active Students</div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">
                            {{ $overallStats['total_grades'] }}
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Total Grades</div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-2xl font-bold text-orange-600 dark:text-orange-400">
                            {{ number_format($overallStats['overall_average'], 2) }}
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Overall Average</div>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="mb-8 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Filter Options</h3>
                    <div class="flex flex-wrap gap-4">
                        <div class="flex-1 min-w-[200px]">
                            <label for="subject-filter"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Filter by Subject
                            </label>
                            <select id="subject-filter"
                                class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded px-3 py-2">
                                <option value="">All Subjects</option>
                                @foreach ($subjectAverages as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex-1 min-w-[200px]">
                            <label for="performance-filter"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Filter by Performance
                            </label>
                            <select id="performance-filter"
                                class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded px-3 py-2">
                                <option value="">All Performance Levels</option>
                                <option value="excellent">Excellent (4.5+)</option>
                                <option value="good">Good (3.5-4.4)</option>
                                <option value="satisfactory">Satisfactory (2.5-3.4)</option>
                                <option value="needs-improvement">Needs Improvement (1.5-2.4)</option>
                                <option value="unsatisfactory">Unsatisfactory (0-1.4)</option>
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button id="reset-filters"
                                class="px-4 py-2 bg-gray-500 hover:bg-gray-700 text-white rounded">
                                Reset Filters
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Average Grades Bar Chart -->
            <div class="mb-8 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Average Grades by Subject</h3>
                    <div class="relative h-96">
                        <canvas id="averageGradesChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Grade Distribution Chart -->
            <div class="mb-8 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Grade Distribution</h3>
                    <div class="grid grid-cols-5 gap-4">
                        @foreach ($gradeDistribution as $grade)
                            <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div
                                    class="text-2xl font-bold
                                    @if ($grade->grade == 5) text-green-600 dark:text-green-400
                                    @elseif($grade->grade == 4) text-blue-600 dark:text-blue-400
                                    @elseif($grade->grade == 3) text-yellow-600 dark:text-yellow-400
                                    @elseif($grade->grade == 2) text-orange-600 dark:text-orange-400
                                    @else text-red-600 dark:text-red-400 @endif">
                                    {{ $grade->count }}
                                </div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">
                                    Grade {{ $grade->grade }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Subject Averages Table -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                        Average Grades by Subject
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
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
                                @forelse($subjectAverages as $subject)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 subject-row"
                                        data-subject-id="{{ $subject->id }}"
                                        data-average-grade="{{ $subject->average_grade }}">
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
                                                {{ $subject->average_grade ? number_format($subject->average_grade, 2) : 'N/A' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($subject->average_grade)
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
                                            @else
                                                <span
                                                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100">
                                                    No Data
                                                </span>
                                            @endif
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            {{ $subject->total_students }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            {{ $subject->total_grades }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('grades.subject-details', $subject->id) }}"
                                                class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                                View Details
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7"
                                            class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                            No subjects with grades found.
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
        const gradeDistributionData = @json($gradeDistribution);

        // Initialize charts
        let averageGradesChart;

        // Create bar chart for average grades
        function createAverageGradesChart(data = subjectData) {
            const ctx = document.getElementById('averageGradesChart').getContext('2d');

            // Destroy existing chart if it exists
            if (averageGradesChart) {
                averageGradesChart.destroy();
            }

            // Filter out subjects with no grades
            const filteredData = data.filter(subject => subject.average_grade !== null);

            // Extract labels and data
            const labels = filteredData.map(subject => subject.name);
            const averages = filteredData.map(subject => parseFloat(subject.average_grade));

            // Create background colors based on performance
            const backgroundColors = averages.map(avg => {
                if (avg >= 4.5) return 'rgba(34, 197, 94, 0.8)'; // Green
                if (avg >= 3.5) return 'rgba(59, 130, 246, 0.8)'; // Blue
                if (avg >= 2.5) return 'rgba(234, 179, 8, 0.8)'; // Yellow
                if (avg >= 1.5) return 'rgba(249, 115, 22, 0.8)'; // Orange
                return 'rgba(239, 68, 68, 0.8)'; // Red
            });

            const borderColors = averages.map(avg => {
                if (avg >= 4.5) return 'rgba(34, 197, 94, 1)'; // Green
                if (avg >= 3.5) return 'rgba(59, 130, 246, 1)'; // Blue
                if (avg >= 2.5) return 'rgba(234, 179, 8, 1)'; // Yellow
                if (avg >= 1.5) return 'rgba(249, 115, 22, 1)'; // Orange
                return 'rgba(239, 68, 68, 1)'; // Red
            });

            averageGradesChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Average Grade',
                        data: averages,
                        backgroundColor: backgroundColors,
                        borderColor: borderColors,
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
                        },
                        tooltip: {
                            callbacks: {
                                afterLabel: function(context) {
                                    const value = context.parsed.y;
                                    let performance = '';
                                    if (value >= 4.5) performance = 'Excellent';
                                    else if (value >= 3.5) performance = 'Good';
                                    else if (value >= 2.5) performance = 'Satisfactory';
                                    else if (value >= 1.5) performance = 'Needs Improvement';
                                    else performance = 'Unsatisfactory';
                                    return 'Performance: ' + performance;
                                }
                            }
                        }
                    }
                }
            });
        }

        // Filter functionality
        function filterSubjects() {
            const subjectFilter = document.getElementById('subject-filter').value;
            const performanceFilter = document.getElementById('performance-filter').value;

            let filteredData = subjectData;

            // Filter by subject
            if (subjectFilter) {
                filteredData = filteredData.filter(subject => subject.id == subjectFilter);
            }

            // Filter by performance
            if (performanceFilter) {
                filteredData = filteredData.filter(subject => {
                    if (!subject.average_grade) return false;
                    const avg = parseFloat(subject.average_grade);
                    switch (performanceFilter) {
                        case 'excellent':
                            return avg >= 4.5;
                        case 'good':
                            return avg >= 3.5 && avg < 4.5;
                        case 'satisfactory':
                            return avg >= 2.5 && avg < 3.5;
                        case 'needs-improvement':
                            return avg >= 1.5 && avg < 2.5;
                        case 'unsatisfactory':
                            return avg < 1.5;
                        default:
                            return true;
                    }
                });
            }

            // Update chart
            createAverageGradesChart(filteredData);

            // Filter table rows
            filterTable(subjectFilter, performanceFilter);
        }

        // Filter table rows
        function filterTable(subjectFilter, performanceFilter) {
            const rows = document.querySelectorAll('.subject-row');

            rows.forEach(row => {
                const subjectId = row.getAttribute('data-subject-id');
                const averageGrade = parseFloat(row.getAttribute('data-average-grade'));

                let showRow = true;

                // Filter by subject
                if (subjectFilter && subjectId != subjectFilter) {
                    showRow = false;
                }

                // Filter by performance
                if (performanceFilter && !isNaN(averageGrade)) {
                    switch (performanceFilter) {
                        case 'excellent':
                            showRow = showRow && averageGrade >= 4.5;
                            break;
                        case 'good':
                            showRow = showRow && averageGrade >= 3.5 && averageGrade < 4.5;
                            break;
                        case 'satisfactory':
                            showRow = showRow && averageGrade >= 2.5 && averageGrade < 3.5;
                            break;
                        case 'needs-improvement':
                            showRow = showRow && averageGrade >= 1.5 && averageGrade < 2.5;
                            break;
                        case 'unsatisfactory':
                            showRow = showRow && averageGrade < 1.5;
                            break;
                    }
                } else if (performanceFilter && isNaN(averageGrade)) {
                    // Hide rows with no grade data when filtering by performance
                    showRow = false;
                }

                row.style.display = showRow ? '' : 'none';
            });
        }

        // Initialize when page loads
        document.addEventListener('DOMContentLoaded', function() {
            // Create initial chart
            createAverageGradesChart();

            // Add event listeners for filters
            document.getElementById('subject-filter').addEventListener('change', filterSubjects);
            document.getElementById('performance-filter').addEventListener('change', filterSubjects);

            // Reset filters
            document.getElementById('reset-filters').addEventListener('click', function() {
                document.getElementById('subject-filter').value = '';
                document.getElementById('performance-filter').value = '';
                createAverageGradesChart();
                filterTable('', '');
            });
        });
    </script>
</x-app-layout>
