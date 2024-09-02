<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('All Tasks') }}
            </h2>

            @can('create_task')
                <a class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" href="{{ route('tasks.create') }}">Add Task</a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Filter Form -->
                    <form action="{{ route('tasks.index') }}" method="GET" class="mb-6">
                        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                            <!-- Project Filter -->
                            <div>
                                <select name="project_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                                    <option value="">{{ __('All Projects') }}</option>
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->id }}" {{ request('project_id') == $project->id ? 'selected' : '' }}>
                                            {{ $project->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Status Filter -->
                            <div>
                                <select name="status" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                                    <option value="">{{ __('All Statuses') }}</option>
                                    @if (auth()->user()->hasRole('manager'))
                                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>
                                            {{ __('Pending') }}
                                        </option>
                                    @endif
                                    <option value="Working" {{ request('status') == 'Working' ? 'selected' : '' }}>
                                        {{ __('Working') }}
                                    </option>
                                    <option value="Done" {{ request('status') == 'Done' ? 'selected' : '' }}>
                                        {{ __('Done') }}
                                    </option>
                                </select>
                            </div>

                            <!-- Teammate Filter -->
                            @if (auth()->user()->hasRole('manager'))
                                <div>
                                    <select name="teammate_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                                        <option value="">{{ __('All Teammate') }}</option>
                                        @foreach ($teammates as $teammate)
                                            <option value="{{ $teammate->id }}" {{ request('teammate_id') == $teammate->id ? 'selected' : '' }}>
                                                {{ $teammate->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            <!-- Submit Button -->
                            <div>
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    {{ __('Filter') }}
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Display Tasks -->
                    @if($tasks->isEmpty())
                        <div class="text-center py-6">
                            <p class="text-gray-500">No tasks found.</p>
                        </div>
                    @else
                        <table class="w-full table-auto">
                            <thead>
                                <tr>
                                    <th class="border px-4 py-2">ID</th>
                                    <th class="border px-4 py-2 text-left">Task Name</th>
                                    <th class="border px-4 py-2">Project Name</th>
                                    <th class="border px-4 py-2">Description</th>
                                    <th class="border px-4 py-2">Teammate</th>
                                    <th class="border px-4 py-2">Status</th>
                                    <th class="border px-4 py-2">Options</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tasks as $key => $task)
                                    <tr>
                                        <td class="border px-4 py-2 text-center">{{ $task->id }}</td>
                                        <td class="border px-4 py-2 text-left">{{ $task->name }}</td>
                                        <td class="border px-4 py-2 text-center">{{ $task->project->name }}</td>
                                        <td class="border px-4 py-2 text-left">{{ $task->description }}</td>
                                        <td class="border px-4 py-2 text-center">{{ $task->assignedUser->name ?? '' }}</td>
                                        <td class="border px-4 py-2 text-center">{{ $task->status }}</td>
                                        <td class="border px-4 py-2 text-center">
                                            @if (auth()->user()->hasRole('manager'))
                                                <a class="bg-blue-500 hover:bg-blue-700 text-white text-sm py-1 px-2 rounded" href="{{ route('tasks.edit', $task->id) }}">Assign</a>
                                            @elseif (auth()->user()->hasRole('teammate') && $task->status == 'Working')
                                                <form action="{{ route('tasks.complete', $task->id) }}" method="POST">
                                                    @csrf
                                                    @method('patch')
                                                    <button
                                                        onclick="return confirm('Are you sure you done this task?')"
                                                        type="submit" class="bg-blue-500 hover:bg-blue-700 text-white text-sm py-1 px-2 rounded">
                                                        Done
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
