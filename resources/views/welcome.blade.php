<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GymPartner - Apresentação</title>
    <!-- Tailwind CSS ou CSS próprio -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #FF6F00; /* Laranja vibrante */
            font-family: 'Poppins', sans-serif;
            color: white;
        }

        .btn-secondary {
            background-color: white;
            color: #FF6F00;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .btn-secondary:hover {
            background-color: #f5f5f5;
        }
    </style>
</head>
<body class="flex flex-col items-center justify-between min-h-screen">

    <!-- Header -->
    <header class="w-full text-center py-6">
        <h1 class="text-4xl font-bold">GymPartner</h1>
        <p class="text-lg mt-2">Seu parceiro para gerenciar treinos e alunos!</p>
    </header>

    <!-- Main Content -->
    <main class="flex flex-col items-center px-4 space-y-8">
        <!-- Hero Section -->
        <div class="text-center">
            <h2 class="text-3xl font-bold mb-4">Facilidade para Personal Trainers</h2>
            <p class="text-lg">
                Adicione alunos, crie treinos personalizados e acompanhe o progresso deles diretamente pelo app.
            </p>
        </div>

        <!-- Features Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl text-center">
            <!-- Feature 1 -->
            <div class="bg-white text-orange-600 p-6 rounded-lg shadow-lg">
                <h3 class="text-xl font-bold">Treinos Personalizados</h3>
                <p class="mt-2">Crie treinos adaptados a cada aluno, com facilidade e rapidez.</p>
            </div>
            <!-- Feature 2 -->
            <div class="bg-white text-orange-600 p-6 rounded-lg shadow-lg">
                <h3 class="text-xl font-bold">Acompanhamento de Progresso</h3>
                <p class="mt-2">Veja como seus alunos estão se saindo e faça ajustes em tempo real.</p>
            </div>
            <!-- Feature 3 -->
            <div class="bg-white text-orange-600 p-6 rounded-lg shadow-lg">
                <h3 class="text-xl font-bold">Feedback dos Alunos</h3>
                <p class="mt-2">Receba avaliações e melhore ainda mais seus treinos.</p>
            </div>
        </div>
    </main>

    <!-- Call to Action -->
    <footer class="w-full text-center py-6">
        <a href="{{ route('login') }}" class="btn-secondary">Comece Agora</a>
    </footer>
</body>
</html>
