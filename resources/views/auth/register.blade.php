<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GymPartner - Registrar</title>
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
            <h1 class="text-3xl font-bold text-gray-800">Crie sua Conta</h1>
            <p class="text-gray-600 mt-2">Gerencie seus treinos e alunos com facilidade.</p>
        </div>

        <!-- Register Form -->
        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block text-gray-700 font-medium">Nome</label>
                <input type="text" id="name" name="name" required 
                       class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-orange-400" 
                       value="{{ old('name') }}">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-gray-700 font-medium">E-mail</label>
                <input type="email" id="email" name="email" required 
                       class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-orange-400" 
                       value="{{ old('email') }}">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-gray-700 font-medium">Senha</label>
                <input type="password" id="password" name="password" required 
                       class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-orange-400">
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-gray-700 font-medium">Confirme sua Senha</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required 
                       class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-orange-400">
                @error('password_confirmation')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn-primary w-full">Registrar</button>
        </form>

        <!-- Login Link -->
        <div class="mt-6 text-center">
            <p class="text-gray-600">Já tem uma conta? 
                <a href="{{ route('login') }}" class="text-orange-500 font-bold hover:underline">Entre</a>
            </p>
        </div>
    </div>
</body>
</html>
