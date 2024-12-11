<x-app-layout>
    <x-slot name="header">
        <div style="background-color: #e8e2dd; padding: 16px; border-radius: 8px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
            <h1 class="text-4xl font-bold text-center" style="color: #312c27; font-family: 'Hammersmith One', sans-serif; margin: 0;">
                {{ __('Detalhe de cliente') }}
            </h1>
        </div>
    </x-slot>

    <div class="py-12" style="background-color: #e8e2dd;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div style="background-color: #fff; border-radius: 8px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); padding: 16px;">
                <div style="text-align: center; color: #312c27;">
                    <h3 style="font-size: 1.5rem; font-family: 'Hammersmith One', sans-serif; margin-top: 12px;">
                        {{ $data['client']->name }}
                    </h3>

                    <div style="margin-top: 16px;">
                        <p style="font-family: 'Clear Sans', sans-serif; font-size: 1rem; color: #312c27;">
                            <strong>{{ __('Email:') }}</strong> {{ $data['client']->email }}
                        </p>
                        <p style="font-family: 'Clear Sans', sans-serif; font-size: 1rem; color: #312c27; margin-top: 8px;">
                            <strong>{{ __('Entrou em:') }}</strong>
                            {{ \Carbon\Carbon::parse($data['client']->created_at)->format('d/m/Y') }}
                        </p>
                    </div>

                    <div style="margin-top: 40px;">
                        <h4 style="font-size: 1.25rem; font-family: 'Hammersmith One', sans-serif; color: #312c27; text-align: center;">
                            {{ __('Exercicios') }}
                        </h4>

                        @if (!empty($data['exercisesByDay']))
                            @foreach ($data['exercisesByDay'] as $date => $exercises)
                                <div style="margin-top: 20px;">
                                    <h5 style="font-size: 1.25rem; font-family: 'Hammersmith One', sans-serif; color: #312c27;">
                                        {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}
                                    </h5>
                                    <ul style="padding-left: 0;">
                                        @foreach ($exercises as $item)
                                            <li style="margin-bottom: 20px; padding: 16px; background-color: #feb924; border-radius: 8px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
                                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                                    <h6 style="font-size: 1.25rem; font-family: 'Hammersmith One', sans-serif; color: #312c27; text-align: center;">
                                                        {{ $item['exercise']->title }}
                                                    </h6>
                                                    <!-- Botão de lixeira com hover -->
                                                    <form action="{{ route('client.removeExercise', ['client' => $data['client']->id, 'exercise' => $item['exercise']->id]) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" style="background-color: #f87171; color: white; padding: 8px 12px; border-radius: 50%; border: none; cursor: pointer;" title="Apagar exercício deste usuário">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 18px; height: 18px;">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                                <p style="margin-top: 12px; font-family: 'Clear Sans', sans-serif; color: #312c27;">
                                                    {!! nl2br(e($item['exercise']->description)) !!}
                                                </p>
                                                <p style="margin-top: 8px; font-family: 'Clear Sans', sans-serif; color: #312c27;">
                                                    <strong>{{ __('Vencimento:') }}</strong>
                                                    {{ \Carbon\Carbon::parse($item['review']->expiration_date)->format('d/m/Y') }}
                                                </p>
                                                @if ($item['review']->done)
                                                    <p style="margin-top: 8px; font-family: 'Clear Sans', sans-serif; color: #38a169;">
                                                        {{ __('Completado em:') }}
                                                        {{ \Carbon\Carbon::parse($item['review']->done_at)->format('d/m/Y') }}
                                                    </p>
                                                @else
                                                    <p style="margin-top: 8px; font-family: 'Clear Sans', sans-serif; color: #e53e3e;">
                                                        {{ __('Ainda não finalizado') }}
                                                    </p>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        @else
                            <p style="font-family: 'Clear Sans', sans-serif; color: #312c27;">
                                {{ __('Este usuário não tem exercicios') }}
                            </p>
                            <a href="{{ route('exercise.assign', $data['client']->id) }}"
                                style="background-color: #3b82f6; color: white; font-family: 'Clear Sans', sans-serif; font-weight: bold; padding: 12px 20px; border-radius: 8px; text-decoration: none; margin-top: 12px; display: inline-block;">
                                {{ __('Adicionar exercicio') }}
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Botões Editar e Deletar posicionados no final -->
                <div style="margin-top: 40px; text-align: center; display: flex; justify-content: center; gap: 12px;">
                    <a href="{{ route('client.edit', $data['client']->id) }}"
                        style="background-color: #feb924; color: white; font-family: 'Clear Sans', sans-serif; font-weight: bold; padding: 12px 16px; border-radius: 8px; text-decoration: none;">
                        {{ __('Editar cliente') }}
                    </a>
                    <form action="{{ route('client.destroy', $data['client']->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            style="background-color: #f87171; color: white; font-family: 'Clear Sans', sans-serif; font-weight: bold; padding: 12px 16px; border-radius: 8px; border: none; cursor: pointer;">
                            {{ __('Deletar cliente') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
