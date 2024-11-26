<x-app-layout>
    <x-slot name="header">
        <div style="background-color: #e8e2dd; padding: 16px; border-radius: 8px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
            <h1 class="text-4xl font-bold text-center" style="color: #312c27; font-family: 'Hammersmith One', sans-serif; margin: 0;">
                {{ __('Create Exercise Plan') }}
            </h1>
        </div>
    </x-slot>

    <div class="py-12" style="background-color: #e8e2dd;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div style="background-color: #fff; border: 2px solid #feb924; border-radius: 8px; padding: 16px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
                <h2 style="font-size: 1.5rem; font-family: 'Hammersmith One', sans-serif; color: #312c27; margin-bottom: 16px;">
                    {{ __('New Exercise Plan') }}
                </h2>

                <form method="POST" action="{{ route('exercise.store') }}">
                    @csrf

                    <!-- Trainer ID (Hidden) -->
                    <input type="hidden" name="trainer_id" value="{{ Auth::user()->id }}">

                    <!-- Title -->
                    <div style="margin-bottom: 16px;">
                        <label for="title" style="display: block; font-family: 'Hammersmith One', sans-serif; color: #312c27; margin-bottom: 8px;">
                            {{ __('Title') }}
                        </label>
                        <input id="title" type="text" name="title" required autofocus
                            style="width: 100%; padding: 10px; border: 2px solid #feb924; border-radius: 8px; background-color: #e8e2dd; color: #312c27; font-family: 'Clear Sans', sans-serif;">
                    </div>

                    <!-- Select Days and Description -->
                    <div id="days-container" style="margin-bottom: 16px;">
                        <label style="display: block; font-family: 'Hammersmith One', sans-serif; color: #312c27; margin-bottom: 8px;">
                            {{ __('Select Days and Descriptions') }}
                        </label>

                        <div class="day-item" style="margin-bottom: 16px;">
                            <select name="days[]" required
                                style="width: 100%; padding: 10px; border: 2px solid #feb924; border-radius: 8px; background-color: #e8e2dd; color: #312c27; font-family: 'Clear Sans', sans-serif; margin-bottom: 8px;">
                                <option value="Monday">{{ __('Monday') }}</option>
                                <option value="Tuesday">{{ __('Tuesday') }}</option>
                                <option value="Wednesday">{{ __('Wednesday') }}</option>
                                <option value="Thursday">{{ __('Thursday') }}</option>
                                <option value="Friday">{{ __('Friday') }}</option>
                                <option value="Saturday">{{ __('Saturday') }}</option>
                                <option value="Sunday">{{ __('Sunday') }}</option>
                            </select>
                            <textarea name="descriptions[]" rows="3" required
                                placeholder="{{ __('Enter description for this day') }}"
                                style="width: 100%; padding: 10px; border: 2px solid #feb924; border-radius: 8px; background-color: #e8e2dd; color: #312c27; font-family: 'Clear Sans', sans-serif; resize: none;"></textarea>
                        </div>
                    </div>

                    <!-- Add Day Button -->
                    <button type="button" id="add-day"
                        style="background-color: #312c27; color: #feb924; font-family: 'Clear Sans', sans-serif; font-weight: bold; padding: 8px 16px; border-radius: 8px; text-decoration: none; border: none; cursor: pointer;">
                        {{ __('Add Another Day') }}
                    </button>

                    <!-- Submit Button -->
                    <div style="margin-top: 16px;">
                        <button type="submit"
                            style="background-color: #feb924; color: #fff; font-family: 'Clear Sans', sans-serif; font-weight: bold; padding: 12px 20px; border-radius: 8px; text-decoration: none; border: none; cursor: pointer;">
                            {{ __('Create Exercise Plan') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('add-day').addEventListener('click', function () {
            const daysContainer = document.getElementById('days-container');
            const newDay = document.createElement('div');
            newDay.classList.add('day-item');
            newDay.style.marginBottom = '16px';

            newDay.innerHTML = `
                <select name="days[]" required
                    style="width: 100%; padding: 10px; border: 2px solid #feb924; border-radius: 8px; background-color: #e8e2dd; color: #312c27; font-family: 'Clear Sans', sans-serif; margin-bottom: 8px;">
                    <option value="Monday">{{ __('Monday') }}</option>
                    <option value="Tuesday">{{ __('Tuesday') }}</option>
                    <option value="Wednesday">{{ __('Wednesday') }}</option>
                    <option value="Thursday">{{ __('Thursday') }}</option>
                    <option value="Friday">{{ __('Friday') }}</option>
                    <option value="Saturday">{{ __('Saturday') }}</option>
                    <option value="Sunday">{{ __('Sunday') }}</option>
                </select>
                <textarea name="descriptions[]" rows="3" required
                    placeholder="{{ __('Enter description for this day') }}"
                    style="width: 100%; padding: 10px; border: 2px solid #feb924; border-radius: 8px; background-color: #e8e2dd; color: #312c27; font-family: 'Clear Sans', sans-serif; resize: none;"></textarea>
            `;

            daysContainer.appendChild(newDay);
        });
    </script>
</x-app-layout>
