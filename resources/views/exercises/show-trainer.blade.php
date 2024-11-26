<x-app-layout>
    <x-slot name="header">
        <div style="background-color: #e8e2dd; padding: 16px; border-radius: 8px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
            <h1 class="text-4xl font-bold text-center" style="color: #312c27; font-family: 'Hammersmith One', sans-serif; margin: 0;">
                {{ __('Exercise Details') }}
            </h1>
        </div>
    </x-slot>

    <div class="py-12" style="background-color: #e8e2dd;">
        <div class="max-w-5xl mx-auto">
            <!-- Detalhes do Exercício -->
            <div style="background-color: #feb924; padding: 16px; border-radius: 8px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
                <h3 style="font-size: 1.5rem; font-family: 'Hammersmith One', sans-serif; color: #312c27; text-align: center;">
                    {{ $data['exercise']->title }}
                </h3>
                
                <h4 style="margin-top: 16px; font-family: 'Hammersmith One', sans-serif; color: #312c27; text-align: center;">
                    {{ __('Exercise Description by Day') }}
                </h4>
                <!-- Cards para os dias -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mt-4">
                    @foreach ($data['descriptionByDays'] as $day => $desc)
                        <div class="bg-white p-6 rounded-lg shadow-lg">
                            <h5 class="text-xl font-bold text-center text-[#312c27]">{{ __($day) }}</h5>
                            <!-- Convertendo quebras de linha para <br> -->
                            <p class="mt-4 text-center text-[#312c27]">{!! nl2br(e($desc)) !!}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Botão para Atrelar Exercício -->
            <div style="margin-top: 24px; text-align: center;">
                <a href="{{ route('exercise.assign', $data['exercise']->id) }}"
                   style="text-decoration: none; background-color: #312c27; color: #feb924; font-family: 'Hammersmith One', sans-serif; padding: 12px 24px; border-radius: 8px; display: inline-block; font-size: 1.1rem; font-weight: bold; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
                    {{ __('Assign to a Client') }}
                </a>
            </div>

            <!-- Lista de Clientes -->
            <div style="margin-top: 24px; background-color: #e8e2dd; padding: 16px; border-radius: 8px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
                <h4 style="font-size: 1.25rem; font-family: 'Hammersmith One', sans-serif; color: #312c27; text-align: center;">
                    {{ __('Clients with this exercise') }}
                </h4>

                @if (empty($data['clients']))
                    <div style="display: flex; align-items: center; justify-content: center; height: 100px;">
                        <p style="font-family: 'Clear Sans', sans-serif; font-size: 1rem; color: #312c27;">
                            {{ __('No clients are assigned to this exercise.') }}
                        </p>
                    </div>
                @else
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-top: 20px;">
                        @foreach ($data['clients'] as $key => $client)
                            <a href="{{ route('client.show', $client->id) }}" style="text-decoration: none; display: block;">
                                <div style="background-color: #feb924; border: 2px solid #312c27; border-radius: 8px; padding: 12px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); min-height: 250px; display: flex; flex-direction: column; justify-content: space-between;">
                                    <h5 style="font-family: 'Hammersmith One', sans-serif; font-size: 1.25rem; color: #312c27; text-align: center;">
                                        {{ $client->name }}
                                    </h5>
                                    <p style="margin-top: 8px; font-family: 'Clear Sans', sans-serif; color: #312c27; text-align: center;">
                                        {{ $client->email }}
                                    </p>
                                    <p style="margin-top: 4px; font-family: 'Clear Sans', sans-serif; font-size: 0.9rem; color: #312c27; text-align: center;">
                                        {{ __('Joined at:') }} {{ $client->created_at->format('d/m/Y') }}
                                    </p>

                                    <!-- Status e Review -->
                                    <div style="margin-top: 8px; text-align: center;">
                                        @if (!$data['reviews'][$key]->done)
                                            <p style="color: red; font-family: 'Clear Sans', sans-serif; margin: 0;">
                                                {{ __('This exercise has not been done!') }}
                                            </p>
                                        @else
                                            <p style="color: green; font-family: 'Clear Sans', sans-serif; margin: 0;">
                                                ✔️ {{ __('This exercise is done!') }}
                                            </p>
                                        @endif
                                    </div>

                                    <h6 style="margin-top: 8px; font-family: 'Clear Sans', sans-serif; font-size: 1rem; color: #312c27; text-align: center;">
                                        {{ __('Review of training') }}
                                    </h6>
                                    @if (isset($data['reviews'][$key]) && $data['reviews'][$key]->review)
                                        <p style="margin-top: 4px; padding: 8px; border-radius: 8px; background-color: #fff; border: 1px solid #312c27; font-family: 'Clear Sans', sans-serif; color: #312c27; text-align: center;">
                                            {{ Str::limit($data['reviews'][$key]->review, 50) }}
                                        </p>
                                    @else
                                        <p style="font-family: 'Clear Sans', sans-serif; color: #312c27; text-align: center;">
                                            {{ __('No review available.') }}
                                        </p>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
