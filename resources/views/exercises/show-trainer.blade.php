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

            @if (!$exercise->done)
                <p class="text-green-500 mb-4">
                    {{ __('This exercise has not been done!') }} <span class="ml-2 text-green-500">✔️</span>
                </p>
            @else
                <p class="text-green-500 mb-4">
                    {{ __('This exercise is done!') }} <span class="ml-2 text-green-500">✔️</span>
                </p>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h4 class="font-semibold text-lg text-gray-800 dark:text-gray-200">
                        {{ __('Review of training') }}
                    </h4>
                    @if ($review && $review->review)
                        <p class="mt-2 p-2 rounded-md bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                            {{ $review->review }}
                        </p>
                    @else
                        <p class="mt-2 text-gray-600 dark:text-gray-400">
                            {{ __('No review available.') }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-4">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h4 class="font-semibold text-lg text-gray-800 dark:text-gray-200">
                        {{ __('Clients with this exercise') }}
                    </h4>
                    @if ($clients->isEmpty())
                        <p class="mt-2 text-gray-600 dark:text-gray-400">
                            {{ __('No clients are assigned to this exercise.') }}
                        </p>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mt-4">
                            @foreach ($clients as $client)
                                <a href="{{ route('client.show', $client->id) }}"
                                    class="block rounded-lg shadow p-4 hover:bg-gray-100 bg-gray-500">
                                    <h4 class="font-semibold text-gray-800 dark:text-gray-200">
                                        {{ $client->name }}
                                    </h4>
                                    <p class="text-gray-600 dark:text-gray-400 mt-2">
                                        {{ $client->email }}
                                    </p>
                                    <p class="text-gray-600 dark:text-gray-400 mt-2">
                                        {{ __('Joined at:') }} {{ $client->created_at->format('d/m/Y') }}
                                    </p>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
