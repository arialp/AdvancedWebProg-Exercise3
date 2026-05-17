<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Projects') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-4">
                <a href="{{ route('projects.create') }}" class="bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-700">{{ __('Create New Project') }}</a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6 text-gray-900 border-b border-gray-200 text-lg font-bold">
                    {{ __('Projects I Manage') }}
                </div>
                <div class="p-6">
                    @if($managedProjects->isEmpty())
                        <p class="text-gray-500">{{ __('You are not managing any projects.') }}</p>
                    @else
                        <ul class="space-y-4">
                            @foreach($managedProjects as $project)
                                <li class="border border-gray-200 p-4 rounded flex justify-between items-center">
                                    <div>
                                        <h3 class="font-bold text-gray-800">{{ $project->name }}</h3>
                                        <p class="text-sm text-gray-600">{{ $project->description }}</p>
                                    </div>
                                    <div class="space-x-2">
                                        <a href="{{ route('projects.show', $project) }}" class="text-blue-600 hover:underline">{{ __('View') }}</a>
                                        <a href="{{ route('projects.edit', $project) }}" class="text-gray-600 hover:underline">{{ __('Edit') }}</a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 border-b border-gray-200 text-lg font-bold">
                    {{ __('Projects I Joined') }}
                </div>
                <div class="p-6">
                    @if($joinedProjects->isEmpty())
                        <p class="text-gray-500">{{ __('You have not joined any projects.') }}</p>
                    @else
                        <ul class="space-y-4">
                            @foreach($joinedProjects as $project)
                                <li class="border border-gray-200 p-4 rounded flex justify-between items-center">
                                    <div>
                                        <h3 class="font-bold text-gray-800">{{ $project->name }}</h3>
                                        <p class="text-sm text-gray-600">{{ __('Manager') }}: {{ $project->manager->name }}</p>
                                    </div>
                                    <div class="space-x-2">
                                        <a href="{{ route('projects.show', $project) }}" class="text-blue-600 hover:underline">{{ __('View') }}</a>
                                        <a href="{{ route('projects.edit', $project) }}" class="text-gray-600 hover:underline">{{ __('Edit') }}</a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
