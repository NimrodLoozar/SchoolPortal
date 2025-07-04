<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Subject Details') }}: {{ $subject->name }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('grades.average') }}"
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Back to Average Grades') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Subject Information -->
            <div class="mb-8 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                {{ $subject->name }}
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Subject Code: {{ $subject->code }}
                            </p>
                            @if ($subject->description)
                                <p class="mt-2 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $subject->description }}
                                </p>
                            @endif
                        </div>
                        <div class="text-right">
                            <div class="text-3xl font-bold text-blue-600 dark:text-blue-400">
                                {{ number_format($subjectStats['average_grade'], 2) }}
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Average Grade</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="mb-8 grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-2xl font-bold text-green-600 dark:text-green-400">
                            {{ $subjectStats['total_students'] }}
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Students</div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">
                            {{ $subjectStats['total_grades'] }}
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Total Grades</div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-2xl font-bold text-green-600 dark:text-green-400">
                            {{ $subjectStats['highest_grade'] }}
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Highest Grade</div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-2xl font-bold text-red-600 dark:text-red-400">
                            {{ $subjectStats['lowest_grade'] }}
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Lowest Grade</div>
                    </div>
                </div>
            </div>

            <!-- Students and Grades -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                        Student Grades for {{ $subject->name }}
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
                                        Grade
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Performance
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Graded By
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Date
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
                                @forelse($studentsWithGrades as $student)
                                    @foreach ($student->grades as $grade)
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
                                                        <div
                                                            class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                            {{ $student->user->name }}
                                                        </div>
                                                        @if ($student->class)
                                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                                Class: {{ $student->class }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-blue-600 dark:text-blue-400">
                                                    {{ $student->student_number }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                                    {{ $grade->grade }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                                    @if ($grade->grade >= 5) bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100
                                                    @elseif($grade->grade >= 4) bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100
                                                    @elseif($grade->grade >= 3) bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100
                                                    @elseif($grade->grade >= 2) bg-orange-100 text-orange-800 dark:bg-orange-800 dark:text-orange-100
                                                    @else bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100 @endif">
                                                    {{ $grade->performance_level }}
                                                </span>
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                {{ $grade->teacher->user->name ?? 'Unknown' }}
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                {{ $grade->graded_at ? $grade->graded_at->format('M d, Y') : 'N/A' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @empty
                                    <tr>
                                        <td colspan="6"
                                            class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                            No students with grades found for this subject.
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
</x-app-layout>
