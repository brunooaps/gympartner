<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight text-center">
            {{ __('Designar exercício para usuário') }}
        </h2>
    </x-slot>

    <div class="flex justify-center mt-8">
        <div class="w-full max-w-4xl px-4">
            <div class="card shadow-lg rounded-lg bg-white">
                <div class="card-header bg-blue-500 text-white p-4 rounded-t-lg">
                    <h3 class="text-lg font-bold text-center">
                        {{ __('Designar exercício para usuário') }}
                    </h3>
                </div>
                <div class="card-body p-6 space-y-6">
                    @if (empty($users))
                        <div class="text-center p-6">
                            <p class="text-lg font-medium text-red-600 mb-4">
                                {{ __('Nenhum cliente cadastrado.') }}
                            </p>
                            <a href="{{ route('client.create') }}"
                               class="text-white font-bold py-2 px-4 rounded"
                               style="background-color: #312c27; font-family: 'Hammersmith One', sans-serif; transition: background-color 0.3s; border: none; cursor: pointer;"
                               onmouseover="this.style.backgroundColor='#feb924';"
                               onmouseout="this.style.backgroundColor='#312c27';">
                                {{ __('Cadastrar Cliente') }}
                            </a>
                        </div>
                    @else
                        <form action="{{ route('exercise.assignToUser') }}" method="POST">
                            @csrf
                            <input type="hidden" name="exercise_id" value="{{ $exercises->first()->id }}">

                            {{-- <!-- Detalhes do Exercício -->
                            <div class="card mb-6 border border-gray-200 shadow-sm rounded-lg">
                                <div class="card-header bg-gray-100 p-4 rounded-t-lg">
                                    <h4 class="font-semibold text-gray-700">{{ __('Detalhes do exercício') }}</h4>
                                </div>
                                <div class="card-body p-4 space-y-4">
                                    <!-- Título do Exercício -->
                                    <div>
                                        <label for="title" class="block font-medium text-gray-600">{{ __('Título') }}</label>
                                        <input type="text" id="title" name="title"
                                               value="{{ $exercises->first()->title }}"
                                               class="input w-full border rounded-lg p-2 text-gray-700 bg-gray-50" readonly>
                                    </div>

                                    <!-- Descrição do Exercício -->
                                    <div>
                                        <label for="description"
                                               class="block font-medium text-gray-600">{{ __('Descrição') }}</label>
                                        <textarea id="description" name="description" rows="5"
                                                  class="input w-full border rounded-lg p-2 text-gray-700 bg-gray-50" readonly>{{ $exercises->first()->description }}</textarea>
                                    </div>
                                </div>
                            </div> --}}

                            <!-- Seleção de Usuário -->
                            <div class="card mb-6 border border-gray-200 shadow-sm rounded-lg">
                                <div class="card-header bg-gray-100 p-4 rounded-t-lg">
                                    <h4 class="font-semibold text-gray-700">{{ __('Selecione o usuário') }}</h4>
                                </div>
                                <div class="card-body p-4">
                                    <label for="user_id" class="block font-medium text-gray-600">{{ __('Usuário') }}</label>
                                    <select id="user_id" name="user_id"
                                            class="input w-full border rounded-lg p-2 text-gray-700 bg-gray-50">
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }} - {{ $user->email }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Data de Vencimento -->
                            <div class="card mb-6 border border-gray-200 shadow-sm rounded-lg">
                                <div class="card-header bg-gray-100 p-4 rounded-t-lg">
                                    <h4 class="font-semibold text-gray-700">{{ __('Data de validade') }}</h4>
                                </div>
                                <div class="card-body p-4">
                                    <label for="expiration_date" class="block font-medium text-gray-600">{{ __('Data de validade') }}</label>
                                    <input type="date" id="expiration_date" name="expiration_date"
                                           class="input w-full border rounded-lg p-2 text-gray-700 bg-gray-50" required>
                                </div>
                            </div>

                            <!-- Botão de Salvar -->
                            <div class="card border border-gray-200 shadow-sm rounded-lg">
                                <div class="card-body p-4 text-center">
                                    <button type="submit"
                                            class="w-auto text-white rounded-md px-6 py-2 text-sm font-semibold"
                                            style="background-color: #312c27; font-family: 'Hammersmith One', sans-serif; transition: background-color 0.3s; border: none; cursor: pointer;"
                                            onmouseover="this.style.backgroundColor='#feb924';"
                                            onmouseout="this.style.backgroundColor='#312c27';">
                                        {{ __('Designar Exercício') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>