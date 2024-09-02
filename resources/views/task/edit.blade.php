<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Assign Task') }}
            </h2>

            <a class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" href="{{ route('tasks.index') }}">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('tasks.update', $task->id) }}">
                        @csrf
                        @method('patch')

                        <!-- Task Name -->
                        <div>
                            <x-input-label for="name" :value="__('Task Name')" />
                            <x-text-input id="name" class="block mt-1 w-full cursor-not-allowed" type="text" name="name" :value="$task->name" disabled />
                        </div>

                        <!-- Project Code -->
                        <div class="mt-4">
                            <x-input-label for="project_code" :value="__('Project Code')" />
                            <x-text-input id="project_code" class="block mt-1 w-full cursor-not-allowed" type="text" name="project_code" :value="$task->project->code" disabled />
                        </div>

                        {{-- <!-- Status -->
                        <div class="mt-4">
                            <x-input-label for="status" :value="__('Status')" />
                            <select name="status" id="status" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required >
                                <option value="" disabled >Select status</option>
                                <option value="Pending" {{ old('status', $task->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Working" {{ old('status', $task->status) == 'Working' ? 'selected' : '' }}>Working</option>
                                <option value="Done" {{ old('status', $task->status) == 'Done' ? 'selected' : '' }}>Done</option>

                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div> --}}

                        <!-- Teammate ID -->
                        <div class="mt-4">
                            <x-input-label for="teammate_id" :value="__('Teammate')" />
                            <select name="teammate_id" id="teammate_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required >
                                <option value="" selected>Select a teammate</option>
                                @foreach ($teammates as $teammate)
                                <option value="{{ $teammate->id }}" {{ old('teammate_id') == $teammate->id ? 'selected' : '' }}>{{ $teammate->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('teammate_id')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-4">
                                {{ __('Assign') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
