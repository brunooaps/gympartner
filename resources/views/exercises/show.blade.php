<x-app-layout>
    <x-slot name="header">
        <div
            style="background-color: #e8e2dd; padding: 16px; border-radius: 8px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
            <h1 class="text-4xl font-bold text-center"
                style="color: #312c27; font-family: 'Hammersmith One', sans-serif; margin: 0;">
                {{ __('Detalhes de Treino') }}
            </h1>
        </div>
    </x-slot>

    <div class="py-12" style="background-color: #e8e2dd;">
        <div class="max-w-5xl mx-auto">
            <!-- Planner dos dias -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach ($exerciseDetails['descriptionByDays'] as $day => $exercises)
                    @if (!empty($exercises))
                        <div
                            style="background-color: #feb924; border: 2px solid #312c27; border-radius: 8px; padding: 16px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
                            <h3
                                style="font-size: 1.5rem; font-family: 'Hammersmith One', sans-serif; color: #312c27; text-align: center;">
                                {{ __($day) }}
                            </h3>
                            @foreach ($exercises as $exercise)
                                <div
                                    style="margin-top: 8px; font-family: 'Clear Sans', sans-serif; color: #312c27; padding: 8px; background-color: #e8e2dd; border: 1px solid #312c27; border-radius: 8px;">
                                    <p><strong>{{ __('Nome:') }}</strong> {{ $exercise['nome'] }}</p>
                                    <p><strong>{{ __('Séries:') }}</strong> {{ $exercise['series'] }}</p>
                                    <p><strong>{{ __('Repetições:') }}</strong> {{ $exercise['repeticoes'] }}</p>
                                    <p><strong>{{ __('Peso:') }}</strong> {{ $exercise['peso'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
