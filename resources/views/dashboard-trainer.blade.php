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
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight mt-4">
                            {{ __('Your Clients') }}
                        </h3>
                        <a href="{{ route('client.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('Create Client') }}
                        </a>
                    </div>

                    @if($clients->isEmpty())
                        <p class="mt-2 text-gray-600 dark:text-gray-400">
                            {{ __('You have no clients.') }}
                        </p>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mt-4">
                            @foreach($clients as $client)
                                <a href="{{ route('client.show', $client->id) }}" class="block rounded-lg shadow p-4 hover:bg-gray-100 bg-gray-500">
                                    <h4 class="font-semibold text-gray-800 dark:text-gray-200 flex items-center">
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
