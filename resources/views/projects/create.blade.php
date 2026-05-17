<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Project') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('projects.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 font-bold mb-2">{{ __('Project Name') }}</label>
                            <input type="text" name="name" id="name" class="w-full border-gray-300 rounded focus:ring-0 focus:border-gray-500" value="{{ old('name') }}" required>
                            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-gray-700 font-bold mb-2">{{ __('Description') }}</label>
                            <textarea name="description" id="description" rows="4" class="w-full border-gray-300 rounded focus:ring-0 focus:border-gray-500">{{ old('description') }}</textarea>
                            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4 flex space-x-4">
                            <div class="w-1/3">
                                <label for="price" class="block text-gray-700 font-bold mb-2">{{ __('Price') }}</label>
                                <input type="number" step="0.01" name="price" id="price" class="w-full border-gray-300 rounded focus:ring-0 focus:border-gray-500" value="{{ old('price', 0) }}">
                                @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div class="w-1/3">
                                <label for="start_date" class="block text-gray-700 font-bold mb-2">{{ __('Start Date') }}</label>
                                <input type="date" name="start_date" id="start_date" class="w-full border-gray-300 rounded focus:ring-0 focus:border-gray-500" value="{{ old('start_date') }}">
                                @error('start_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div class="w-1/3">
                                <label for="end_date" class="block text-gray-700 font-bold mb-2">{{ __('End Date') }}</label>
                                <input type="date" name="end_date" id="end_date" class="w-full border-gray-300 rounded focus:ring-0 focus:border-gray-500" value="{{ old('end_date') }}">
                                @error('end_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 font-bold mb-2">{{ __('Team Members') }}</label>
                            <div class="border border-gray-300 rounded p-4 max-h-48 overflow-y-auto">
                                @foreach($users as $user)
                                    <div class="flex items-center mb-2">
                                        <input type="checkbox" name="team_members[]" value="{{ $user->id }}" id="user_{{ $user->id }}" class="mr-2 focus:ring-0 border-gray-300 rounded" {{ (is_array(old('team_members')) && in_array($user->id, old('team_members'))) ? 'checked' : '' }}>
                                        <label for="user_{{ $user->id }}" class="text-gray-700">{{ $user->name }} ({{ $user->email }})</label>
                                    </div>
                                @endforeach
                            </div>
                            @error('team_members') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex items-center justify-end">
                            <a href="{{ route('projects.index') }}" class="text-gray-600 hover:underline mr-4">{{ __('Cancel') }}</a>
                            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-700">
                                {{ __('Create Project') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
