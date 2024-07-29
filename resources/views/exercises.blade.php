<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Exercises') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight mt-4">
                        {{ __('Your Exercises') }}
                    </h3>

                    @if($exercises->isEmpty())
                        <p class="mt-2 text-gray-600 dark:text-gray-400">
                            {{ __('You have no exercises.') }}
                        </p>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mt-4">
                            @foreach($exercises as $exercise)
                                @php
                                    $route = Auth::user()->access_level == 'trainer' 
                                        ? route('exercise.show-trainer', $exercise->id) 
                                        : route('exercise.show', $exercise->id);
                                @endphp
                                <a href="{{ $route }}" class="block rounded-lg shadow p-4 hover:bg-gray-100 bg-gray-500">
                                    <h4 class="font-semibold text-gray-800 dark:text-gray-200 flex items-center">
                                        {{ $exercise->title }}
                                        @if($exercise->done && Auth::user()->access_level != 'trainer')
                                            <span class="ml-2 text-green-500">✔️</span>
                                        @endif
                                    </h4>
                                    <p class="text-gray-600 dark:text-gray-400 mt-2">
                                        {{ \Illuminate\Support\Str::limit($exercise->description, 100) }}
                                    </p>
                                    @if($exercise->next_due_date && Auth::user()->access_level != 'trainer')
                                        <p class="text-gray-600 dark:text-gray-400 mt-2">
                                            {{ __('Next due date:') }} {{ $exercise->next_due_date }}
                                        </p>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
