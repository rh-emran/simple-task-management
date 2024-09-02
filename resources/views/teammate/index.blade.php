<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('All Teammates') }}
            </h2>

            <a class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" href="{{ route('teammates.create') }}">Add Teammate</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($teammates->isEmpty())
                        <div class="text-center py-6">
                            <p class="text-gray-500">No teammates found.</p>
                        </div>
                    @else
                        <table class="w-full table-auto">
                            <thead>
                                <tr>
                                    <th class="border px-4 py-2">ID</th>
                                    <th class="border px-4 py-2 text-left">Name</th>
                                    <th class="border px-4 py-2">Employee ID</th>
                                    <th class="border px-4 py-2">Email</th>
                                    <th class="border px-4 py-2">Position</th>
                                    <th class="border px-4 py-2">Options</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($teammates as $key => $teammate)
                                    <tr>
                                        <td class="border px-4 py-2 text-center">{{ $teammate->id }}</td>
                                        <td class="border px-4 py-2 text-left">{{ $teammate->name }}</td>
                                        <td class="border px-4 py-2 text-center">{{ $teammate->employee_id }}</td>
                                        <td class="border px-4 py-2">{{ $teammate->email }}</td>
                                        <td class="border px-4 py-2 text-left">{{ $teammate->position }}</td>
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
