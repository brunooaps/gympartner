<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Exercise Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-4">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="font-semibold text-2xl text-gray-800 dark:text-gray-200">
                        {{ $exercise->title }}
                    </h3>
                    <p class="mt-4 text-gray-600 dark:text-gray-400">
                        {!! nl2br(e($exercise->description)) !!}
                    </p>
                </div>
            </div>

            @if(!$exercise->done)
                <form method="POST" action="{{ route('exercise.markAsDone', $exercise->id) }}" class="mb-4">
                    @csrf
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                        {{ __('Mark as Done') }}
                    </button>
                </form>
            @else
                <p class="text-green-500 mb-4">
                    {{ __('This exercise is done!') }} <span class="ml-2 text-green-500">✔️</span>
                </p>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h4 class="font-semibold text-lg text-gray-800 dark:text-gray-200">
                        {{ __('Review your training') }}
                    </h4>
                    <form method="POST" action="{{ route('exercise.addDescription', $exercise->id) }}">
                        @csrf
                        <textarea name="client_description" rows="4" class="w-full mt-2 p-2 rounded-md bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">{{ old('client_description', $exercise->client_description) }}</textarea>
                        <button type="submit" class="mt-4 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                            {{ __('Submit') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
