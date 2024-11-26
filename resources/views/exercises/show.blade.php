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

            <!-- Status do Exercício -->
            <div
                style="margin-top: 24px; background-color: #e8e2dd; padding: 16px; border-radius: 8px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
                @php
                    // Parse a data de expiração e o dia de hoje, considerando apenas as datas (sem hora)
                    $expirationDate = \Carbon\Carbon::parse($exerciseDetails['review']->expiration_date)->startOfDay();
                    $today = \Carbon\Carbon::today()->startOfDay();

                    // Calcular a diferença em dias
                    $daysLeft = $today->diffInDays($expirationDate, false); // false para permitir valores negativos
                @endphp

                @if ($daysLeft > 0)
                    <p style="font-family: 'Clear Sans', sans-serif; color: #228B22; text-align: center;">
                        {{ __('This exercise will expire in') }} {{ $daysLeft }} {{ __('days.') }} 🏋️‍♂️
                    </p>
                @elseif ($daysLeft === 0)
                    <p style="font-family: 'Clear Sans', sans-serif; color: #228B22; text-align: center;">
                        {{ __('This exercise expires today!') }} 🏋️‍♀️
                    </p>
                @else
                    <p style="font-family: 'Clear Sans', sans-serif; color: #FF0000; text-align: center;">
                        {{ __('This exercise has expired!') }} ❌
                    </p>
                @endif
            </div>


            <!-- Avaliação -->
            <div
                style="margin-top: 24px; background-color: #fff; border: 2px solid #feb924; border-radius: 8px; padding: 16px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
                <h4
                    style="font-size: 1.25rem; font-family: 'Hammersmith One', sans-serif; color: #312c27; text-align: center;">
                    {{ __('Review your training') }}
                </h4>
                <p style="margin-top: 16px; font-family: 'Clear Sans', sans-serif; color: #312c27; text-align: center;">
                    {!! nl2br(e($exerciseDetails['review']->review ?? __('No reviews available.'))) !!}
                </p>
                <div style="margin-top: 16px; text-align: center;">
                    <button onclick="openModal()"
                        style="background-color: #312c27; color: #feb924; font-family: 'Hammersmith One', sans-serif; padding: 12px 24px; border-radius: 8px; font-size: 1.1rem; font-weight: bold; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
                        {{ __('Edit Review') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="editReviewModal" class="hidden fixed z-10 inset-0 overflow-y-auto"
        style="background-color: rgba(0, 0, 0, 0.5);">
        <div class="flex items-center justify-center min-h-screen px-4 py-6 sm:px-0">
            <div
                style="background-color: #fff; border: 2px solid #feb924; border-radius: 8px; padding: 16px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); width: 100%; max-width: 500px;">
                <!-- Título com botão de fechar -->
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <h3
                        style="font-size: 1.5rem; font-family: 'Hammersmith One', sans-serif; color: #312c27; text-align: center; margin: 0;">
                        {{ __('Edit Review') }}
                    </h3>
                    <!-- Botão para fechar o modal -->
                    <button onclick="closeModal()"
                        style="background-color: transparent; color: #312c27; font-size: 1.5rem; font-weight: bold; border: none; cursor: pointer; padding: 0;">
                        &times; <!-- Ícone "X" -->
                    </button>
                </div>
                <form method="POST" action="{{ route('exercise.addDescription', $exerciseDetails['exercise']->id) }}"
                    style="margin-top: 16px;">
                    @csrf
                    <textarea name="client_description" rows="4"
                        style="width: 100%; padding: 8px; border: 2px solid #feb924; border-radius: 8px; font-family: 'Clear Sans', sans-serif; color: #312c27; resize: none;">{{ old('client_description', $exerciseDetails['review']->review ?? '') }}</textarea>
                    <div class="flex justify-end" style="margin-top: 16px;">
                        <button type="submit"
                            style="background-color: #312c27; color: #feb924; font-family: 'Hammersmith One', sans-serif; padding: 8px 16px; border-radius: 8px; font-size: 1.1rem; font-weight: bold; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
                            {{ __('Save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        // Função para abrir o modal
        function openModal() {
            document.getElementById('editReviewModal').classList.remove('hidden');
        }

        // Função para fechar o modal
        function closeModal() {
            document.getElementById('editReviewModal').classList.add('hidden');
        }
    </script>

</x-app-layout>
