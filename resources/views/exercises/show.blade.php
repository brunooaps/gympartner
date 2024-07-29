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
                        {{ $exerciseDetails['exercise']->title }}
                    </h3>
                    <p class="mt-4 text-gray-600 dark:text-gray-400">
                        {!! nl2br(e($exerciseDetails['exercise']->description)) !!}
                    </p>
                </div>
            </div>

            @if(!$exerciseDetails['review']->done)
                <form method="POST" action="{{ route('exercise.markAsDone', $exerciseDetails['exercise']->id) }}" class="mb-4">
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
                <div class="p-6 text-gray-900 dark:text-gray-100 flex justify-between items-center">
                    <h4 class="font-semibold text-lg text-gray-800 dark:text-gray-200">
                        {{ __('Review your training') }}
                    </h4>
                    <button onclick="openModal()" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">
                        {{ __('Edit') }}
                    </button>
                </div>
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <p class="mt-4 text-gray-600 dark:text-gray-400">
                        {!! nl2br(e($exerciseDetails['review']->review ?? 'No reviews available.')) !!}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="editReviewModal" class="hidden fixed z-10 inset-0 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 py-6 sm:px-0">
            <div class="fixed inset-0 transition-opacity">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg w-full">
                <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-200">
                                {{ __('Edit Review') }}
                            </h3>
                            <div class="mt-2">
                                <form method="POST" action="{{ route('exercise.addDescription', $exerciseDetails['exercise']->id) }}">
                                    @csrf
                                    <textarea name="client_description" rows="4" class="w-full mt-2 p-2 rounded-md bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">{{ old('client_description', $exerciseDetails['review']->first()->review) }}</textarea>
                                    <div class="mt-4 flex justify-end">
                                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded mr-2">
                                            {{ __('Save') }}
                                        </button>
                                        <button type="button" onclick="closeModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                                            {{ __('Cancel') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('editReviewModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('editReviewModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
