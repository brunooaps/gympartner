<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Client Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight mt-4">
                        {{ $data['client']->name }}
                    </h3>

                    <div class="mt-4">
                        <p class="text-gray-600 dark:text-gray-400">
                            <strong>{{ __('Email:') }}</strong> {{ $data['client']->email }}
                        </p>
                        <p class="text-gray-600 dark:text-gray-400 mt-2">
                            <strong>{{ __('Joined at:') }}</strong>
                            {{ \Carbon\Carbon::parse($data['client']->created_at)->format('d/m/Y') }}
                        </p>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('client.edit', $data['client']->id) }}"
                            class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('Edit Client') }}
                        </a>
                        <form action="{{ route('client.destroy', $data['client']->id) }}" method="POST"
                            class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Delete Client') }}
                            </button>
                        </form>
                    </div>

                    <div class="mt-8">
                        <h4 class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight">
                            {{ __('Exercises') }}
                        </h4>
                        <ul class="mt-4">
                            @if (!empty($data['exercises']))
                                @foreach ($data['exercises'] as $index => $exercise)
                                    <li class="mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-md shadow-sm">
                                        <h5 class="text-xl font-bold text-gray-800 dark:text-gray-200">
                                            {{ $exercise->title }}
                                        </h5>
                                        <p class="mt-2 text-gray-600 dark:text-gray-400">
                                            {!! nl2br(e($exercise->description)) !!}
                                        </p>
                                        <p class="mt-2 text-gray-600 dark:text-gray-400">
                                            <strong>{{ __('Created at:') }}</strong>
                                            {{ \Carbon\Carbon::parse($exercise->created_at)->format('d/m/Y') }}
                                        </p>
                                        @php
                                            $review = $data['reviews'][$index] ?? null;
                                        @endphp
                                        @if ($review && $review->done)
                                            <p class="mt-2 text-green-500">
                                                {{ __('Completed at:') }}
                                                {{ \Carbon\Carbon::parse($review->done_at)->format('d/m/Y') }}
                                            </p>
                                        @else
                                            <p class="mt-2 text-red-500">
                                                {{ __('Not completed yet') }}
                                            </p>
                                        @endif
                                    </li>
                                @endforeach
                            @else
                                <p>{{ __('This user has no exercises') }}</p>
                                <a href="{{ route('exercise.assign', $data['client']->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4">
                                    {{ __('Assign Exercise') }}
                                </a>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
