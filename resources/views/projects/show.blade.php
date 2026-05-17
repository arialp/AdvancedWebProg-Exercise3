<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Project Details') }}: {{ $project->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="mb-6">
                        <h3 class="text-lg font-bold border-b pb-2">{{ __('General Information') }}</h3>
                        <div class="mt-4 grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500 font-bold">{{ __('Name') }}</p>
                                <p>{{ $project->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-bold">{{ __('Manager') }}</p>
                                <p>{{ $project->manager->name }}</p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-sm text-gray-500 font-bold">{{ __('Description') }}</p>
                                <p>{{ $project->description ?: '-' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-bold">{{ __('Price') }}</p>
                                <p>{{ number_format($project->price, 2) }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-bold">{{ __('Done Jobs') }}</p>
                                <p>{{ $project->done_jobs }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-bold">{{ __('Start Date') }}</p>
                                <p>{{ $project->start_date ? $project->start_date->format('Y-m-d') : '-' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-bold">{{ __('End Date') }}</p>
                                <p>{{ $project->end_date ? $project->end_date->format('Y-m-d') : '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-lg font-bold border-b pb-2">{{ __('Team Members') }}</h3>
                        @if($project->teamMembers->isEmpty())
                            <p class="mt-4 text-gray-500">{{ __('No team members assigned.') }}</p>
                        @else
                            <ul class="mt-4 list-disc list-inside">
                                @foreach($project->teamMembers as $member)
                                    <li>{{ $member->name }} ({{ $member->email }})</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    <div class="flex items-center justify-between mt-8 border-t pt-4">
                        <a href="{{ route('projects.index') }}" class="text-blue-600 hover:underline">{{ __('Back to Projects') }}</a>
                        
                        <div class="flex space-x-2">
                            <a href="{{ route('projects.edit', $project) }}" class="bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-700">{{ __('Edit') }}</a>
                            
                            @if(auth()->user()->id === $project->manager_id)
                                <form action="{{ route('projects.destroy', $project) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure you want to delete this project?') }}');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-500">{{ __('Delete') }}</button>
                                </form>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
