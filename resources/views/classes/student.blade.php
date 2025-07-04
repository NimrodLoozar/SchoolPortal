<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Student Details') }}: {{ $student->user->name }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('classes.show', $student->class) }}"
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Back to Class') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Student Header -->
            <div class="mb-8 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0 h-20 w-20">
                            <div
                                class="h-20 w-20 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                                <span class="text-2xl font-medium text-gray-700 dark:text-gray-300">
                                    {{ strtoupper(substr($student->user->name, 0, 2)) }}
                                </span>
                            </div>
                        </div>
                        <div class="ml-6 flex-1">
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                {{ $student->user->name }}
                            </h3>
                            <div class="mt-2 grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <span class="font-medium text-gray-500 dark:text-gray-400">Student Number:</span>
                                    <span
                                        class="text-blue-600 dark:text-blue-400 font-bold">{{ $student->student_number }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-500 dark:text-gray-400">Class:</span>
                                    <span class="text-gray-900 dark:text-gray-100">{{ $student->class }}</span>
                                </div>
                                @if ($student->birth_date)
                                    <div>
                                        <span class="font-medium text-gray-500 dark:text-gray-400">Birth Date:</span>
                                        <span
                                            class="text-gray-900 dark:text-gray-100">{{ $student->birth_date->format('M d, Y') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-3xl font-bold text-blue-600 dark:text-blue-400">
                                {{ number_format($studentStats['overall_average'], 2) }}
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Overall Average</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Student Statistics -->
            <div class="mb-8 grid grid-cols-1 md:grid-cols-5 gap-4">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                            {{ number_format($studentStats['overall_average'], 2) }}
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Overall Average</div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">
                            {{ $studentStats['total_subjects'] }}
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Subjects</div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-2xl font-bold text-green-600 dark:text-green-400">
                            {{ $studentStats['total_grades'] }}
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Total Grades</div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-2xl font-bold text-green-600 dark:text-green-400">
                            {{ $studentStats['highest_grade'] }}
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Highest Grade</div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-2xl font-bold text-red-600 dark:text-red-400">
                            {{ $studentStats['lowest_grade'] }}
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Lowest Grade</div>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            @if ($student->user->contact)
                <div class="mb-8 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Contact Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @if ($student->user->contact->email)
                                <div>
                                    <span class="font-medium text-gray-500 dark:text-gray-400">Email:</span>
                                    <span
                                        class="text-gray-900 dark:text-gray-100">{{ $student->user->contact->email }}</span>
                                </div>
                            @endif
                            @if ($student->user->contact->phone)
                                <div>
                                    <span class="font-medium text-gray-500 dark:text-gray-400">Phone:</span>
                                    <span
                                        class="text-gray-900 dark:text-gray-100">{{ $student->user->contact->phone }}</span>
                                </div>
                            @endif
                            @if ($student->user->contact->address)
                                <div>
                                    <span class="font-medium text-gray-500 dark:text-gray-400">Address:</span>
                                    <span
                                        class="text-gray-900 dark:text-gray-100">{{ $student->user->contact->address }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Subject Performance Overview -->
            <div class="mb-8 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Subject Performance</h3>
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
                                        Total Grades
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Highest
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Lowest
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
                                @forelse($subjectData as $data)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ $data['subject']->name }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 dark:text-gray-100">
                                                {{ $data['subject']->code }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-bold text-gray-900 dark:text-gray-100">
                                                {{ number_format($data['average_grade'], 2) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                                @if ($data['average_grade'] >= 4.5) bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100
                                                @elseif($data['average_grade'] >= 3.5) bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100
                                                @elseif($data['average_grade'] >= 2.5) bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100
                                                @elseif($data['average_grade'] >= 1.5) bg-orange-100 text-orange-800 dark:bg-orange-800 dark:text-orange-100
                                                @else bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100 @endif">
                                                @if ($data['average_grade'] >= 4.5)
                                                    Excellent
                                                @elseif($data['average_grade'] >= 3.5)
                                                    Good
                                                @elseif($data['average_grade'] >= 2.5)
                                                    Satisfactory
                                                @elseif($data['average_grade'] >= 1.5)
                                                    Needs Improvement
                                                @else
                                                    Unsatisfactory
                                                @endif
                                            </span>
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            {{ $data['total_grades'] }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            {{ $data['highest_grade'] }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            {{ $data['lowest_grade'] }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7"
                                            class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                            No grades found for this student.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Detailed Grades by Subject -->
            @foreach ($subjectData as $data)
                <div class="mb-8 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                            {{ $data['subject']->name }} - Detailed Grades
                        </h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full table-auto">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
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
                                            Teacher
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Date
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Description
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
                                    @foreach ($data['grades'] as $grade)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
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
                                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                                {{ $grade->description ?? '-' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
