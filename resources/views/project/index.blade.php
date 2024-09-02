<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('All Projects') }}
            </h2>

            <a class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" href="{{ route('projects.create') }}">Add Project</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Search Form -->
                    <form method="GET" action="{{ route('projects.index') }}" class="mb-6">
                        <input type="text" name="search" value="{{ old('search', $search) }}" placeholder="Search project by name" class="border-gray-300 rounded-md shadow-sm mr-4">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Search</button>
                    </form>

                    <!-- Display Tasks -->
                    @if($projects->isEmpty())
                        <div class="text-center py-6">
                            <p class="text-gray-500">No projects found.</p>
                        </div>
                    @else
                        <table class="w-full table-auto">
                            <thead>
                                <tr>
                                    <th class="border px-4 py-2">ID</th>
                                    <th class="border px-4 py-2 text-left">Project Name</th>
                                    <th class="border px-4 py-2">Project Code</th>
                                    <th class="border px-4 py-2">Options</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($projects as $key => $project)
                                    <tr>
                                        <td class="border px-4 py-2 text-center">{{ $project->id }}</td>
                                        <td class="border px-4 py-2 text-left">{{ $project->name }}</td>
                                        <td class="border px-4 py-2 text-left">{{ $project->code }}</td>
                                        <td class="border px-4 py-2 text-center">
                                            <!-- Add your actions here, e.g., edit and delete buttons -->
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
