<x-app-layout>
    <x-slot name="header">
        <div class="header-container">
            <h1 class="header-title">
                {{ __('Criar exercício') }}
            </h1>
        </div>
    </x-slot>

    <div class="content-container">
        <div class="form-container">
            <h2 class="form-title">
                {{ __('Criar novo exercício') }}
            </h2>

            <form method="POST" action="{{ route('exercise.store') }}">
                @csrf

                <!-- Trainer ID (Hidden) -->
                <input type="hidden" name="trainer_id" value="{{ Auth::user()->id }}">

                <!-- Title -->
                <div class="form-group">
                    <label for="title" class="form-label">
                        {{ __('Titulo') }}
                    </label>
                    <input id="title" type="text" name="title" required autofocus class="form-input">
                </div>

                <!-- Select Days and Description -->
                <div id="days-container" class="form-group">
                    <label class="form-label">
                        {{ __('Selecione os dias e descrição') }}
                    </label>

                    <div class="day-buttons">
                        <button type="button" class="day-button" data-day="Segunda">Segunda</button>
                        <button type="button" class="day-button" data-day="Terça">Terça</button>
                        <button type="button" class="day-button" data-day="Quarta">Quarta</button>
                        <button type="button" class="day-button" data-day="Quinta">Quinta</button>
                        <button type="button" class="day-button" data-day="Sexta">Sexta</button>
                        <button type="button" class="day-button" data-day="Sábado">Sábado</button>
                        <button type="button" class="day-button" data-day="Domingo">Domingo</button>
                    </div>

                    <div id="exercise-table-container" style="display: none;">
                        <table id="exercise-table" class="exercise-table">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Séries</th>
                                    <th>Repetições</th>
                                    <th>Peso</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <button type="button" id="add-exercise" class="add-exercise-button">
                        Adicionar Exercício
                    </button>
                </div>

                <input type="hidden" id="days-data" name="days_data">

                <!-- Submit Button -->
                <div class="form-actions">
                    <button type="submit" class="submit-button">
                        {{ __('Criar exercício') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const dayButtons = document.querySelectorAll('.day-button');
        const exerciseTableBody = document.querySelector('#exercise-table tbody');
        const addExerciseButton = document.getElementById('add-exercise');
        const daysDataInput = document.getElementById('days-data');
        const exerciseTableContainer = document.getElementById('exercise-table-container');

        let selectedDays = new Set();
        let dayExercises = {}; // Store exercises per day

        function refreshTable() {
            exerciseTableBody.innerHTML = '';
            if (selectedDays.size === 0) return;

            const commonExercises = [...selectedDays].reduce((acc, day) => {
                if (!dayExercises[day]) dayExercises[day] = [];
                return acc.length === 0 ? [...dayExercises[day]] : acc;
            }, []);

            commonExercises.forEach((exercise, index) => {
                const row = document.createElement('tr');
                row.innerHTML = 
                    `<td><input type="text" value="${exercise.nome || ''}" class="exercise-name"></td>
                    <td><input type="text" value="${exercise.series || ''}" class="exercise-series"></td>
                    <td><input type="text" value="${exercise.repeticoes || ''}" class="exercise-repetitions"></td>
                    <td><input type="text" value="${exercise.peso || ''}" class="exercise-weight"></td>
                    <td><button type="button" class="delete-exercise" data-index="${index}">Remover</button></td>`;
                exerciseTableBody.appendChild(row);
            });

            updateHiddenInput();
        }

        function updateHiddenInput() {
            daysDataInput.value = JSON.stringify(dayExercises);
        }

        dayButtons.forEach(button => {
            button.addEventListener('click', () => {
                const day = button.dataset.day;
                if (selectedDays.has(day)) {
                    selectedDays.delete(day);
                    button.classList.remove('selected-day');
                } else {
                    selectedDays.add(day);
                    button.classList.add('selected-day');
                }

                refreshTable();
            });
        });

        addExerciseButton.addEventListener('click', () => {
            const newExercise = { nome: '', series: '', repeticoes: '', peso: '' };

            [...selectedDays].forEach(day => {
                if (!dayExercises[day]) dayExercises[day] = [];
                dayExercises[day].push(newExercise);
            });

            refreshTable();
            exerciseTableContainer.style.display = 'block'; // Show the table after adding an exercise
        });

        exerciseTableBody.addEventListener('input', (event) => {
            const target = event.target;
            const row = target.closest('tr');
            const index = [...exerciseTableBody.children].indexOf(row);

            [...selectedDays].forEach(day => {
                if (!dayExercises[day]) dayExercises[day] = [];
                if (!dayExercises[day][index]) dayExercises[day][index] = { nome: '', series: '', repeticoes: '', peso: '' };
                const exercise = dayExercises[day][index];

                if (target.classList.contains('exercise-name')) exercise.nome = target.value;
                if (target.classList.contains('exercise-series')) exercise.series = target.value;
                if (target.classList.contains('exercise-repetitions')) exercise.repeticoes = target.value;
                if (target.classList.contains('exercise-weight')) exercise.peso = target.value;
            });

            updateHiddenInput();
        });

        exerciseTableBody.addEventListener('click', (event) => {
            if (event.target.classList.contains('delete-exercise')) {
                const index = event.target.dataset.index;

                [...selectedDays].forEach(day => {
                    if (dayExercises[day]) {
                        dayExercises[day].splice(index, 1);
                    }
                });

                refreshTable();
            }
        });
    </script>

    <style>
        .header-container {
            background-color: #e8e2dd;
            padding: 16px;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header-title {
            color: #312c27;
            font-family: 'Hammersmith One', sans-serif;
            margin: 0;
            text-align: center;
        }

        .content-container {
            background-color: #e8e2dd;
            padding: 12px;
        }

        .form-container {
            background-color: #fff;
            border: 2px solid #feb924;
            border-radius: 8px;
            padding: 16px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .form-title {
            font-size: 1.5rem;
            font-family: 'Hammersmith One', sans-serif;
            color: #312c27;
            margin-bottom: 16px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-label {
            display: block;
            font-family: 'Hammersmith One', sans-serif;
            color: #312c27;
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            padding: 10px;
            border: 2px solid #feb924;
            border-radius: 8px;
            background-color: #e8e2dd;
            color: #312c27;
            font-family: 'Clear Sans', sans-serif;
        }

        .day-buttons {
            display: flex;
            gap: 8px;
            margin-bottom: 16px;
        }

        .day-button {
            padding: 8px 16px;
            background-color: #fff;
            border: 2px solid #feb924;
            border-radius: 8px;
            cursor: pointer;
        }

        .day-button.selected-day {
            background-color: #feb924;
            color: #312c27;
        }

        .exercise-table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 8px;
            margin-top: 16px;
            border: 2px solid #feb924;
        }

        .exercise-table th, .exercise-table td {
            padding: 12px;
            text-align: center;
            border: 1px solid #feb924;
        }

        .add-exercise-button {
            padding: 8px 16px;
            background-color: #feb924;
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            display: block;
            margin: 16px auto;
        }

        .submit-button {
            padding: 12px 24px;
            background-color: #feb924;
            color: #fff;
            border: none;
            border-radius: 8px;
            width: 100%;
            cursor: pointer;
            font-size: 1rem;
        }

        .submit-button:hover {
            background-color: #f8a900;
        }
    </style>
</x-app-layout>
