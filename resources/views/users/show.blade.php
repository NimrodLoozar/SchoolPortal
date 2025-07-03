<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('User Details') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('users.edit', $user) }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Edit User') }}
                </a>
                <a href="{{ route('users.index') }}"
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Back to Users') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- User Header -->
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0 h-20 w-20">
                            <div
                                class="h-20 w-20 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                                <span class="text-2xl font-medium text-gray-700 dark:text-gray-300">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </span>
                            </div>
                        </div>
                        <div class="ml-6">
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                {{ $user->name }}
                            </h3>
                            <div class="flex items-center space-x-4 mt-2">
                                <span
                                    class="inline-flex px-3 py-1 text-sm font-semibold rounded-full
                                    @if ($user->role === 'Owner') bg-purple-100 text-purple-800 dark:bg-purple-800 dark:text-purple-100
                                    @elseif($user->role === 'Schedule_admin') bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100
                                    @elseif($user->role === 'Teacher') bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100
                                    @else bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100 @endif">
                                    {{ $user->role }}
                                </span>
                                <span
                                    class="inline-flex px-3 py-1 text-sm font-semibold rounded-full
                                    {{ $user->is_active ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' : 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100' }}">
                                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- User Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Basic Information -->
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <h4 class="font-semibold text-lg mb-4 text-gray-900 dark:text-gray-100">Basic Information
                            </h4>
                            <dl class="space-y-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">User ID</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $user->id }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Name</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $user->name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Role</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $user->role }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">
                                        {{ $user->is_active ? 'Active' : 'Inactive' }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Created</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">
                                        {{ $user->created_at->format('F d, Y \a\t g:i A') }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Updated</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">
                                        {{ $user->updated_at->format('F d, Y \a\t g:i A') }}
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Contact Information -->
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <h4 class="font-semibold text-lg mb-4 text-gray-900 dark:text-gray-100">Contact Information
                            </h4>
                            @if ($user->contact)
                                <dl class="space-y-2">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
                                        <dd class="text-sm text-gray-900 dark:text-gray-100">
                                            {{ $user->contact->email }}</dd>
                                    </div>
                                    @if ($user->contact->phone)
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Phone</dt>
                                            <dd class="text-sm text-gray-900 dark:text-gray-100">
                                                {{ $user->contact->phone }}</dd>
                                        </div>
                                    @endif
                                    @if ($user->contact->address)
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Address
                                            </dt>
                                            <dd class="text-sm text-gray-900 dark:text-gray-100">
                                                {{ $user->contact->address }}</dd>
                                        </div>
                                    @endif
                                </dl>
                            @else
                                <p class="text-sm text-gray-500 dark:text-gray-400">No contact information available.
                                </p>
                            @endif
                        </div>
                    </div>

                    <!-- Comments -->
                    @if ($user->comment)
                        <div class="mt-6 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <h4 class="font-semibold text-lg mb-2 text-gray-900 dark:text-gray-100">Comments</h4>
                            <p class="text-sm text-gray-900 dark:text-gray-100">{{ $user->comment }}</p>
                        </div>
                    @endif

                    <!-- Role-specific Information -->
                    @if ($user->student)
                        <div class="mt-6 bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
                            <h4 class="font-semibold text-lg mb-4 text-gray-900 dark:text-gray-100">Student Information
                            </h4>
                            <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Student ID</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $user->student->id }}</dd>
                                </div>
                                @if ($user->student->date_of_birth)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Date of Birth
                                        </dt>
                                        <dd class="text-sm text-gray-900 dark:text-gray-100">
                                            {{ \Carbon\Carbon::parse($user->student->date_of_birth)->format('F d, Y') }}
                                        </dd>
                                    </div>
                                @endif
                                @if ($user->student->grade_level)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Grade Level
                                        </dt>
                                        <dd class="text-sm text-gray-900 dark:text-gray-100">
                                            {{ $user->student->grade_level }}</dd>
                                    </div>
                                @endif
                            </dl>
                        </div>
                    @endif

                    @if ($user->teacher)
                        <div class="mt-6 bg-green-50 dark:bg-green-900/20 p-4 rounded-lg">
                            <h4 class="font-semibold text-lg mb-4 text-gray-900 dark:text-gray-100">Teacher Information
                            </h4>
                            <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Teacher ID</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $user->teacher->id }}</dd>
                                </div>
                                @if ($user->teacher->specialization)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Specialization
                                        </dt>
                                        <dd class="text-sm text-gray-900 dark:text-gray-100">
                                            {{ $user->teacher->specialization }}</dd>
                                    </div>
                                @endif
                                @if ($user->teacher->hire_date)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Hire Date</dt>
                                        <dd class="text-sm text-gray-900 dark:text-gray-100">
                                            {{ \Carbon\Carbon::parse($user->teacher->hire_date)->format('F d, Y') }}
                                        </dd>
                                    </div>
                                @endif
                            </dl>
                        </div>
                    @endif

                    <!-- Actions -->
                    <div class="mt-8 flex space-x-4 pt-6 border-t border-gray-200 dark:border-gray-600">
                        <a href="{{ route('users.edit', $user) }}"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Edit User
                        </a>

                        <form action="{{ route('users.toggle-active', $user) }}" method="POST"
                            style="display: inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                                {{ $user->is_active ? 'Deactivate' : 'Activate' }}
                            </button>
                        </form>

                        @if ($user->id !== auth()->id())
                            <form action="{{ route('users.destroy', $user) }}" method="POST" style="display: inline;"
                                onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                    Delete User
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
