<x-app-layout>
    <x-slot name="header">
        <div
            style="background-color: #e8e2dd; padding: 16px; border-radius: 8px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
            <h1 class="text-4xl font-bold text-center"
                style="color: #312c27; font-family: 'Hammersmith One', sans-serif; margin: 0;">
                {{ __('Exercise Details') }}
            </h1>
        </div>
    </x-slot>

    <div class="py-12" style="background-color: #e8e2dd;">
        <div class="max-w-5xl mx-auto">
            <div
                style="margin-top: 24px; background-color: #fff; padding: 16px; border-radius: 8px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
                <h4
                    style="font-size: 1.5rem; font-family: 'Hammersmith One', sans-serif; color: #312c27; text-align: center; margin-bottom: 16px;">
                    {{ $exerciseDetails['exercise']->title }}
                </h4>
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px;">
                    @forelse ($exerciseDetails['descriptionByDays'] as $day => $description)
                        <div
                            style="background-color: #e8e2dd; padding: 16px; border-radius: 8px; border: 2px solid #feb924; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
                            <h5
                                style="font-family: 'Hammersmith One', sans-serif; color: #312c27; font-size: 1.25rem; text-align: left; margin-bottom: 8px;">
                                {{ __($day) }}
                            </h5>
                            <p
                                style="font-family: 'Clear Sans', sans-serif; color: #312c27; text-align: left; white-space: pre-line;">
                                {{ $description }}
                            </p>
                        </div>
                    @empty
                        <p style="font-family: 'Clear Sans', sans-serif; color: #312c27; text-align: center;">
                            {{ __('No exercises assigned for this week.') }}
                        </p>
                    @endforelse
                </div>
            </div>

            <!-- Chat -->
            <div
                style="margin-top: 24px; background-color: #fff; border: 2px solid #feb924; border-radius: 8px; padding: 16px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
                @php
                    // Verifica se o usuário logado é o treinador ou o cliente
                    $isTrainer = $exerciseDetails['exercise']->trainer_id == auth()->id();
                @endphp

                <h4
                    style="font-size: 1.25rem; font-family: 'Hammersmith One', sans-serif; color: #312c27; text-align: center;">
                    {{ $isTrainer ? __('Chat with your Client') : __('Chat with your Trainer') }}
                </h4>
                <div id="chatBox" style="max-height: 300px; overflow-y: auto; margin-top: 16px;">
                    @foreach ($exerciseDetails['chats'] as $chat)
                        @php
                            // Verifica se o usuário autenticado é o treinador ou o cliente
                            $isCurrentUser = $chat->user_id == auth()->id() || $chat->trainer_id == auth()->id();
                        @endphp

                        <div style="display: flex; justify-content: {{ $isCurrentUser ? 'flex-end' : 'flex-start' }};">
                            <div
                                style="background-color: {{ $isCurrentUser ? '#feb924' : '#e8e2dd' }}; padding: 8px 16px; border-radius: 8px; margin-bottom: 8px; max-width: 60%; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
                                <p style="font-family: 'Clear Sans', sans-serif; color: #312c27; margin: 0;">
                                    {{ $chat->commentary }}
                                </p>
                                <div style="font-size: 0.75rem; color: #6b6b6b; margin-top: 4px; text-align: right;">
                                    {{ $chat->user_id == auth()->id() ? 'You' : $chat->user->name ?? 'Trainer' }} -
                                    {{ \Carbon\Carbon::parse($chat->created_at)->format('H:i') }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <form method="POST" action="{{ route('chat.store') }}" style="margin-top: 16px;">
                    @csrf
                    <input type="hidden" name="exercise_id" value="{{ $exerciseDetails['exercise']->id }}">
                    <div style="display: flex; gap: 8px;">
                        <textarea name="commentary" rows="2"
                            style="flex: 1; padding: 8px; border: 2px solid #feb924; border-radius: 8px; font-family: 'Clear Sans', sans-serif; color: #312c27; resize: none;"></textarea>
                        <button type="submit"
                            style="background-color: #312c27; color: #feb924; font-family: 'Hammersmith One', sans-serif; padding: 8px 16px; border-radius: 8px; font-size: 1.1rem; font-weight: bold; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
                            {{ __('Send') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
