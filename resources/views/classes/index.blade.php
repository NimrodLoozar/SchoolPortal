<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Class Management') }}
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
            <div class="mb-8 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                            {{ $overviewData->getTotalClasses() }}
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Total Classes</div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-2xl font-bold text-green-600 dark:text-green-400">
                            {{ $overviewData->getTotalStudents() }}
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Total Students</div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-2xl font-bold text-orange-600 dark:text-orange-400">
                            {{ $overviewData->getFormattedOverallAverageGrade() }}
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Overall Average</div>
                    </div>
                </div>
            </div>

            <!-- Classes Chart -->
            <div class="mb-8 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Class Overview</h3>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Students per Class Chart -->
                        <div>
                            <h4 class="text-md font-medium text-gray-700 dark:text-gray-300 mb-2">Students per Class
                            </h4>
                            <div class="relative h-64">
                                <canvas id="studentsPerClassChart"></canvas>
                            </div>
                        </div>
                        <!-- Average Grades per Class Chart -->
                        <div>
                            <h4 class="text-md font-medium text-gray-700 dark:text-gray-300 mb-2">Average Grades per
                                Class</h4>
                            <div class="relative h-64">
                                <canvas id="averageGradesPerClassChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Classes Table -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                        All Classes
                    </h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Class Name
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Students
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Subjects
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
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
                                @forelse($classes as $class)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <div
                                                        class="h-10 w-10 rounded-full bg-blue-100 dark:bg-blue-800 flex items-center justify-center">
                                                        <span
                                                            class="text-sm font-medium text-blue-800 dark:text-blue-100">
                                                            {{ $class->getClassInitials() }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                        {{ $class->class }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 dark:text-gray-100">
                                                {{ $class->students_count }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 dark:text-gray-100">
                                                {{ $class->subjects_count }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-bold text-gray-900 dark:text-gray-100">
                                                {{ $class->getFormattedAverageGrade() }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $class->performance_color_class }}">
                                                {{ $class->performance_level }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('classes.show', $class->class) }}"
                                                class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                                View Details
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6"
                                            class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                            No classes found.
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
        // Data for charts from DTO
        const chartData = @json($overviewData->getChartData());

        // Create charts when page loads
        document.addEventListener('DOMContentLoaded', function() {
            createStudentsPerClassChart();
            createAverageGradesPerClassChart();
        });

        // Students per Class Chart
        function createStudentsPerClassChart() {
            const ctx = document.getElementById('studentsPerClassChart').getContext('2d');

            const labels = chartData.map(cls => cls.class);
            const data = chartData.map(cls => cls.students_count);

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Number of Students',
                        data: data,
                        backgroundColor: 'rgba(59, 130, 246, 0.8)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
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

        // Average Grades per Class Chart
        function createAverageGradesPerClassChart() {
            const ctx = document.getElementById('averageGradesPerClassChart').getContext('2d');

            const labels = chartData.map(cls => cls.class);
            const averages = chartData.map(cls => parseFloat(cls.average_grade));

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

            new Chart(ctx, {
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
                                    const performanceLevel = chartData[context.dataIndex].performance_level;
                                    return 'Performance: ' + performanceLevel;
                                }
                            }
                        }
                    }
                }
            });
        }
    </script>
</x-app-layout>
