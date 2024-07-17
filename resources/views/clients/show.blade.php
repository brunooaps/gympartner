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
                        {{ $client->name }}
                    </h3>

                    <div class="mt-4">
                        <p class="text-gray-600 dark:text-gray-400">
                            <strong>{{ __('Email:') }}</strong> {{ $client->email }}
                        </p>
                        <p class="text-gray-600 dark:text-gray-400 mt-2">
                            <strong>{{ __('Joined at:') }}</strong> {{ $client->created_at->format('d/m/Y') }}
                        </p>
                        <!-- Add more fields as necessary -->
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('client.edit', $client->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('Edit Client') }}
                        </a>
                        <form action="{{ route('client.destroy', $client->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Delete Client') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
