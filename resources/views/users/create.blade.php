<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Create New User') }}
            </h2>
            <a href="{{ route('users.index') }}"
                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Back to Users') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('users.store') }}">
                        @csrf

                        <!-- Name -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Name') }}
                            </label>
                            <input id="name"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm @error('name') border-red-500 @enderror"
                                type="text" name="name" value="{{ old('name') }}" required autofocus />
                            @error('name')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Role -->
                        <div class="mb-4">
                            <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Role') }}
                            </label>
                            <select id="role" name="role"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm @error('role') border-red-500 @enderror"
                                required onchange="toggleRoleSpecificFields()">>
                                <option value="">{{ __('Select a role') }}</option>
                                <option value="Student" {{ old('role') === 'Student' ? 'selected' : '' }}>Student
                                </option>
                                <option value="Teacher" {{ old('role') === 'Teacher' ? 'selected' : '' }}>Teacher
                                </option>
                                <option value="Schedule_admin"
                                    {{ old('role') === 'Schedule_admin' ? 'selected' : '' }}>Schedule Admin</option>
                                <option value="Owner" {{ old('role') === 'Owner' ? 'selected' : '' }}>Owner</option>
                            </select>
                            @error('role')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror

                            <!-- Student Info Notice -->
                            <div id="student-info"
                                class="mt-2 p-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-md"
                                style="display: none;">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">
                                            {{ __('Student Account Information') }}
                                        </h3>
                                        <div class="mt-2 text-sm text-blue-700 dark:text-blue-300">
                                            <ul class="list-disc list-inside space-y-1">
                                                <li>{{ __('A unique student number will be automatically generated') }}
                                                </li>
                                                <li>{{ __('School email will be created as: [student_number]@school.com') }}
                                                </li>
                                                <li>{{ __('Student record will be linked to this user account') }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="mb-4" id="email-field">
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Email Address') }}
                            </label>
                            <input id="email"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm @error('email') border-red-500 @enderror"
                                type="email" name="email" value="{{ old('email') }}"
                                placeholder="{{ __('Enter email address...') }}" />
                            @error('email')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ __('Required for all roles except Student (students get auto-generated school emails).') }}
                            </p>
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Password') }}
                            </label>
                            <input id="password"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm @error('password') border-red-500 @enderror"
                                type="password" name="password" required />
                            @error('password')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ __('Minimum 8 characters required.') }}
                            </p>
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-4">
                            <label for="password_confirmation"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Confirm Password') }}
                            </label>
                            <input id="password_confirmation"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm"
                                type="password" name="password_confirmation" required />
                        </div>

                        <!-- Active Status -->
                        <div class="mb-4">
                            <div class="flex items-center">
                                <input id="is_active" type="checkbox" name="is_active" value="1"
                                    {{ old('is_active', true) ? 'checked' : '' }}
                                    class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" />
                                <label for="is_active" class="ml-2 block text-sm text-gray-900 dark:text-gray-100">
                                    {{ __('Active User') }}
                                </label>
                            </div>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ __('Inactive users cannot log in to the system.') }}
                            </p>
                        </div>

                        <!-- Comments -->
                        <div class="mb-6">
                            <label for="comment" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Comments') }}
                            </label>
                            <textarea id="comment" name="comment" rows="3"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm @error('comment') border-red-500 @enderror"
                                placeholder="{{ __('Optional notes about this user...') }}">{{ old('comment') }}</textarea>
                            @error('comment')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('users.index') }}"
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Cancel') }}
                            </a>
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Create User') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Help Section -->
            <div class="mt-6 bg-blue-50 dark:bg-blue-900/20 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-blue-900 dark:text-blue-100 mb-3">
                        {{ __('User Roles Information') }}
                    </h3>
                    <div class="space-y-2 text-sm text-blue-800 dark:text-blue-200">
                        <div><strong>Owner:</strong> Full system access, can manage all users and settings</div>
                        <div><strong>Schedule Admin:</strong> Can manage schedules, rooms, and subjects</div>
                        <div><strong>Teacher:</strong> Can view schedules and manage their classes</div>
                        <div><strong>Student:</strong> Can view their own schedule and grades</div>
                    </div>

                    <div class="mt-4 p-3 bg-green-100 dark:bg-green-900/30 rounded-lg">
                        <h4 class="font-medium text-green-900 dark:text-green-100 mb-2">
                            {{ __('Automatic Student Setup') }}
                        </h4>
                        <div class="text-sm text-green-800 dark:text-green-200">
                            <div>• Student number will be auto-generated (format: YYYY####)</div>
                            <div>• School email will be created: [student_number]@school.com</div>
                            <div>• Default class will be set to "Unassigned" (can be updated later)</div>
                            <div>• Default birth date will be set to 2000-01-01 (can be updated later)</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    function toggleRoleSpecificFields() {
        const roleSelect = document.getElementById('role');
        const studentInfo = document.getElementById('student-info');
        const emailField = document.getElementById('email-field');
        const emailInput = document.getElementById('email');

        if (roleSelect.value === 'Student') {
            // Show student info, hide email field for students
            studentInfo.style.display = 'block';
            emailField.style.display = 'none';
            emailInput.required = false;
        } else {
            // Hide student info, show email field for other roles
            studentInfo.style.display = 'none';
            emailField.style.display = 'block';
            emailInput.required = true;
        }
    }

    // Show appropriate fields on page load if role is already selected
    document.addEventListener('DOMContentLoaded', function() {
        toggleRoleSpecificFields();

        // Add event listener to role select
        document.getElementById('role').addEventListener('change', toggleRoleSpecificFields);
    });
</script>
