<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('User Management') }}
            </h2>
            <a href="{{ route('users.create') }}"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Add New User') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                            All Users ({{ $users->total() }} total)
                        </h3>

                        <!-- Search and Filter -->
                        <div class="mb-4">
                            <form method="GET" action="{{ route('users.index') }}" class="flex gap-4">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Search by name..."
                                    class="border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded px-3 py-2 flex-1">

                                <select name="role"
                                    class="border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded px-3 py-2">
                                    <option value="">All Roles</option>
                                    <option value="Owner" {{ request('role') === 'Owner' ? 'selected' : '' }}>Owner
                                    </option>
                                    <option value="Schedule_admin"
                                        {{ request('role') === 'Schedule_admin' ? 'selected' : '' }}>Schedule Admin
                                    </option>
                                    <option value="Teacher" {{ request('role') === 'Teacher' ? 'selected' : '' }}>
                                        Teacher</option>
                                    <option value="Student" {{ request('role') === 'Student' ? 'selected' : '' }}>
                                        Student</option>
                                </select>

                                <select name="status"
                                    class="border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded px-3 py-2">
                                    <option value="">All Status</option>
                                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>
                                        Active</option>
                                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>
                                        Inactive</option>
                                </select>

                                <button type="submit"
                                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                    Filter
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Users Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        User
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Role
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Email
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Created
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
                                @forelse($users as $user)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <div
                                                        class="h-10 w-10 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                                                        <span
                                                            class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                        {{ $user->name }}
                                                    </div>
                                                    @if ($user->role === 'Student' && $user->student)
                                                        <div class="text-sm text-blue-600 dark:text-blue-400">
                                                            Student #: {{ $user->student->student_number }}
                                                        </div>
                                                    @elseif($user->comment)
                                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                                            {{ Str::limit($user->comment, 50) }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                                @if ($user->role === 'Owner') bg-purple-100 text-purple-800 dark:bg-purple-800 dark:text-purple-100
                                                @elseif($user->role === 'Schedule_admin') bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100
                                                @elseif($user->role === 'Teacher') bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100
                                                @else bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100 @endif">
                                                {{ $user->role }}
                                            </span>
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            {{ $user->contact?->email ?? 'No email' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                                {{ $user->is_active ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' : 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100' }}">
                                                {{ $user->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $user->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('users.show', $user) }}"
                                                    class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                                    View
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6"
                                            class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                            No users found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
