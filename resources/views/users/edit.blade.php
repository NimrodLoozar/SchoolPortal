<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit User') }}: {{ $user->name }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('users.show', $user) }}"
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('View User') }}
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
                    <form method="POST" action="{{ route('users.update', $user) }}">
                        @csrf
                        @method('PATCH')

                        <!-- Name -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Name') }}
                            </label>
                            <input id="name"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm @error('name') border-red-500 @enderror"
                                type="text" name="name" value="{{ old('name', $user->name) }}" required
                                autofocus />
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
                                required>
                                <option value="">{{ __('Select a role') }}</option>
                                <option value="Student" {{ old('role', $user->role) === 'Student' ? 'selected' : '' }}>
                                    Student</option>
                                <option value="Teacher" {{ old('role', $user->role) === 'Teacher' ? 'selected' : '' }}>
                                    Teacher</option>
                                <option value="Schedule_admin"
                                    {{ old('role', $user->role) === 'Schedule_admin' ? 'selected' : '' }}>Schedule
                                    Admin</option>
                                <option value="Owner" {{ old('role', $user->role) === 'Owner' ? 'selected' : '' }}>
                                    Owner</option>
                            </select>
                            @error('role')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            @if ($user->role === 'Owner' && $user->id === auth()->id())
                                <p class="mt-1 text-sm text-yellow-600 dark:text-yellow-400">
                                    {{ __('Be careful when changing your own role - you may lose access to this page.') }}
                                </p>
                            @endif
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('New Password') }}
                            </label>
                            <input id="password"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm @error('password') border-red-500 @enderror"
                                type="password" name="password" />
                            @error('password')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ __('Leave blank to keep current password. Minimum 8 characters if changing.') }}
                            </p>
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-4">
                            <label for="password_confirmation"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Confirm New Password') }}
                            </label>
                            <input id="password_confirmation"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm"
                                type="password" name="password_confirmation" />
                        </div>

                        <!-- Active Status -->
                        <div class="mb-4">
                            <div class="flex items-center">
                                <input id="is_active" type="checkbox" name="is_active" value="1"
                                    {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                                    class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" />
                                <label for="is_active" class="ml-2 block text-sm text-gray-900 dark:text-gray-100">
                                    {{ __('Active User') }}
                                </label>
                            </div>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ __('Inactive users cannot log in to the system.') }}
                            </p>
                            @if ($user->id === auth()->id())
                                <p class="mt-1 text-sm text-yellow-600 dark:text-yellow-400">
                                    {{ __('Deactivating your own account will prevent you from logging in.') }}
                                </p>
                            @endif
                        </div>

                        <!-- Comments -->
                        <div class="mb-6">
                            <label for="comment" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Comments') }}
                            </label>
                            <textarea id="comment" name="comment" rows="3"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm @error('comment') border-red-500 @enderror"
                                placeholder="{{ __('Optional notes about this user...') }}">{{ old('comment', $user->comment) }}</textarea>
                            @error('comment')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('users.show', $user) }}"
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Cancel') }}
                            </a>
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Update User') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- User Information -->
            <div class="mt-6 bg-gray-50 dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-3">
                        {{ __('Current User Information') }}
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="font-medium text-gray-700 dark:text-gray-300">{{ __('User ID:') }}</span>
                            <span class="text-gray-900 dark:text-gray-100">{{ $user->id }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700 dark:text-gray-300">{{ __('Created:') }}</span>
                            <span
                                class="text-gray-900 dark:text-gray-100">{{ $user->created_at->format('M d, Y g:i A') }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700 dark:text-gray-300">{{ __('Last Updated:') }}</span>
                            <span
                                class="text-gray-900 dark:text-gray-100">{{ $user->updated_at->format('M d, Y g:i A') }}</span>
                        </div>
                        @if ($user->contact?->email)
                            <div>
                                <span class="font-medium text-gray-700 dark:text-gray-300">{{ __('Email:') }}</span>
                                <span class="text-gray-900 dark:text-gray-100">{{ $user->contact->email }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
