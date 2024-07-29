<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Assign Exercise to : ' . $user->name) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight mt-4">
                        {{ __('User Details') }}
                    </h3>
                    
                    <div class="mt-4">
                        <p class="text-gray-600 dark:text-gray-400">
                            <strong>{{ __('Name:') }}</strong> {{ $user->name }}
                        </p>
                        <p class="text-gray-600 dark:text-gray-400 mt-2">
                            <strong>{{ __('Email:') }}</strong> {{ $user->email }}
                        </p>
                        <p class="text-gray-600 dark:text-gray-400 mt-2">
                            <strong>{{ __('Joined at:') }}</strong> {{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y') }}
                        </p>
                    </div>

                    <div class="mt-8">
                        <h4 class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight">
                            {{ __('Available Exercises') }}
                        </h4>
                        <form action="{{ route('exercise.assignToUser', $user->id) }}" method="POST" class="mt-4">
                            @csrf
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                                @foreach ($exercises as $exercise)
                                    <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-md shadow-sm">
                                        <input type="checkbox" id="exercise_{{ $exercise->id }}" name="exercises[]"
                                            value="{{ $exercise->id }}" class="mr-2">
                                        <label for="exercise_{{ $exercise->id }}" class="text-gray-800 dark:text-gray-200">
                                            {{ $exercise->title }}
                                        </label>
                                        <p class="mt-2 text-gray-600 dark:text-gray-400">
                                            {!! nl2br(e($exercise->description)) !!}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-6">
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    {{ __('Assign Selected Exercises') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
