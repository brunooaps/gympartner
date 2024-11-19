{{-- <x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GymPartner - Bem-vindo</title>
    <!-- Tailwind CSS ou CSS próprio -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #f9f9f9; /* Fundo neutro */
            font-family: 'Poppins', sans-serif;
        }

        .btn-primary {
            background-color: #FF6F00; /* Laranja enérgico */
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #e65c00;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">

    <div class="bg-white shadow-lg rounded-lg p-8 max-w-md w-full">
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Bem-vindo ao GymPartner!</h1>
            <p class="text-gray-600 mt-2">Gerencie seus treinos e alunos com facilidade.</p>
        </div>

        <!-- Login Form -->
        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="email" class="block text-gray-700 font-medium">E-mail</label>
                <input type="email" id="email" name="email" required 
                       class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-orange-400">
            </div>

            <div>
                <label for="password" class="block text-gray-700 font-medium">Senha</label>
                <input type="password" id="password" name="password" required 
                       class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-orange-400">
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center text-gray-600">
                    <input type="checkbox" name="remember" class="mr-2">
                    Lembrar-me
                </label>
                <a href="{{ route('password.request') }}" class="text-orange-500 hover:underline">
                    Esqueceu a senha?
                </a>
            </div>

            <button type="submit" class="btn-primary w-full">Entrar</button>
        </form>

        <!-- Register Link -->
        <div class="mt-6 text-center">
            <p class="text-gray-600">Novo por aqui? 
                <a href="{{ route('register') }}" class="text-orange-500 font-bold hover:underline">Crie uma conta</a>
            </p>
        </div>
    </div>
</body>
</html>
