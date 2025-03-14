<x-app-layout>
    <x-slot name="header">
        <div style="background-color: #e8e2dd; padding: 16px; border-radius: 8px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
            <h1 class="text-4xl font-bold text-center" style="color: #312c27; font-family: 'Hammersmith One', sans-serif; margin: 0;">
                {{ __('Seus clientes') }}
            </h1>
        </div>
    </x-slot>

    <div class="py-12" style="background-color: #e8e2dd;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div style="background-color: #fff; border-radius: 8px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); padding: 16px;">
                <div class="flex justify-between items-center mb-4">
                    <a href="{{ route('client.create') }}"
                        style="background-color: #feb924; color: white; font-family: 'Clear Sans', sans-serif; font-weight: bold; padding: 12px 20px; border-radius: 8px; text-decoration: none;">
                        {{ __('Criar cliente') }}
                    </a>
                </div>

                @if($clients->isEmpty())
                    <p class="mt-2" style="font-family: 'Clear Sans', sans-serif; color: #312c27;">
                        {{ __('Você não tem clientes.') }}
                    </p>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mt-4">
                        @foreach($clients as $client)
                            <a href="{{ route('client.show', $client->hash_id) }}"
                                style="display: block; background-color: #fff; border: 2px solid #feb924; border-radius: 8px; padding: 16px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); text-decoration: none;">
                                <h4 style="font-size: 1.25rem; font-family: 'Hammersmith One', sans-serif; color: #312c27; text-align: center;">
                                    {{ $client->name }}
                                </h4>
                                <p style="font-family: 'Clear Sans', sans-serif; font-size: 1rem; color: #312c27; text-align: center; margin-top: 12px;">
                                    {{ $client->email }}
                                </p>
                                <p style="font-family: 'Clear Sans', sans-serif; font-size: 1rem; color: #312c27; text-align: center; margin-top: 12px;">
                                    <strong>{{ __('Entrou em:') }}</strong> {{ $client->created_at->format('d/m/Y') }}
                                </p>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
