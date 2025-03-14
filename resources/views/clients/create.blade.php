<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-feb924 dark:text-312c27 leading-tight">
            {{ __('Criar um Cliente') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-feb924 dark:bg-312c27 shadow rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('client.store') }}" class="space-y-6">
                        @csrf

                        <!-- Nome -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-312c27 dark:text-feb924">
                                {{ __('Nome') }}
                            </label>
                            <input 
                                id="name" 
                                type="text" 
                                name="name" 
                                value="{{ old('name') }}" 
                                required 
                                autofocus
                                class="mt-1 block w-full rounded-md border-312c27 shadow-sm dark:border-feb924 dark:bg-312c27 dark:text-feb924 focus:border-feb924 focus:ring focus:ring-feb924 sm:text-sm"
                            />
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-312c27 dark:text-feb924">
                                {{ __('Email') }}
                            </label>
                            <input 
                                id="email" 
                                type="email" 
                                name="email" 
                                value="{{ old('email') }}" 
                                required 
                                class="mt-1 block w-full rounded-md border-312c27 shadow-sm dark:border-feb924 dark:bg-312c27 dark:text-feb924 focus:border-feb924 focus:ring focus:ring-feb924 sm:text-sm"
                            />
                        </div>

                        <!-- Nível de Acesso (Oculto) -->
                        <input type="hidden" name="access_level" value="client">

                        <!-- Senha (Oculto) -->
                        <input type="hidden" name="password" value="{{ old('email') }}">

                        <div class="flex items-center justify-end">
                            <button 
                                type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-312c27 text-feb924 font-medium text-sm leading-5 rounded-md shadow-sm hover:bg-feb924 hover:text-312c27 focus:outline-none focus:ring focus:ring-feb924 focus:ring-opacity-50 transition"
                            >
                                {{ __('Criar Cliente') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
