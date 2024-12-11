<x-app-layout>
    <x-slot name="header">
        <div style="background-color: #e8e2dd; padding: 16px; border-radius: 8px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
            <h1 class="text-4xl font-bold text-center" style="color: #312c27; font-family: 'Hammersmith One', sans-serif; margin: 0;">
                {{ __('Detalhes do exercício') }}
            </h1>
        </div>
    </x-slot>

    <div class="py-12" style="background-color: #e8e2dd;">
        <div class="max-w-7xl mx-auto">
            <!-- Planner dos dias -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach ($data['descriptionByDays'] as $day => $exercises)
                @if (!empty($exercises))
                    <div style="background-color: #feb924; border: 2px solid #312c27; border-radius: 8px; padding: 16px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
                        <h3 style="font-size: 1.5rem; font-family: 'Hammersmith One', sans-serif; color: #312c27; text-align: center;">
                            {{ __($day) }}
                        </h3>
                            @foreach ($exercises as $exercise)
                                <div style="margin-top: 8px; font-family: 'Clear Sans', sans-serif; color: #312c27; padding: 8px; background-color: #e8e2dd; border: 1px solid #312c27; border-radius: 8px;">
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

            <!-- Botão para Designar Exercício -->
            <div style="margin-top: 24px; text-align: center;">
                <a href="{{ route('exercise.assign', $data['exercise']->id) }}"
                   style="text-decoration: none; background-color: #312c27; color: #feb924; font-family: 'Hammersmith One', sans-serif; padding: 12px 24px; border-radius: 8px; display: inline-block; font-size: 1.1rem; font-weight: bold; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
                    {{ __('Designar para um cliente') }}
                </a>
            </div>

            <!-- Lista de Clientes -->
            <div style="margin-top: 24px; background-color: #e8e2dd; padding: 16px; border-radius: 8px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
                <h4 style="font-size: 1.25rem; font-family: 'Hammersmith One', sans-serif; color: #312c27; text-align: center;">
                    {{ __('Clientes com esse exercício:') }}
                </h4>

                @if (empty($data['clients']))
                    <div style="display: flex; align-items: center; justify-content: center; height: 100px;">
                        <p style="font-family: 'Clear Sans', sans-serif; font-size: 1rem; color: #312c27;">
                            {{ __('Nenhum cliente está designado para este exercício.') }}
                        </p>
                    </div>
                @else
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-top: 20px;">
                        @foreach ($data['clients'] as $client)
                            <div style="background-color: #feb924; border: 2px solid #312c27; border-radius: 8px; padding: 12px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
                                <h5 style="font-family: 'Hammersmith One', sans-serif; font-size: 1.25rem; color: #312c27; text-align: center;">
                                    {{ $client->name }}
                                </h5>
                                <p style="margin-top: 8px; font-family: 'Clear Sans', sans-serif; color: #312c27; text-align: center;">
                                    {{ $client->email }}
                                </p>
                                <p style="margin-top: 4px; font-family: 'Clear Sans', sans-serif; font-size: 0.9rem; color: #312c27; text-align: center;">
                                    {{ __('Entrou em:') }} {{ $client->created_at->format('d/m/Y') }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
