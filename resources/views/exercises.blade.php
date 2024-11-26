<x-app-layout>
    <div class="py-12" style="background-color: #e8e2dd;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h3 class="font-hammersmith text-2xl text-312c27 mb-6">
                {{ __('Your Exercises') }}
            </h3>

            @if(Auth::user()->access_level == 'trainer')
                <a href="{{ route('exercise.create') }}" 
                   style="background-color: #feb924; color: #312c27; padding: 10px 20px; font-family: 'Clear Sans', sans-serif; border-radius: 8px; text-decoration: none; font-weight: bold;">
                    {{ __('Create Exercise') }}
                </a>
            @endif

            @if(!isset($exercises))
                <p class="mt-6 font-clear-sans text-lg text-312c27">
                    {{ __('You have no exercises.') }}
                </p>
            @else
                <!-- Ajuste na estrutura da grade -->
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; margin-top: 20px;">
                    @foreach($exercises as $exercise)
                        @php
                            $route = Auth::user()->access_level == 'trainer' 
                                ? route('exercise.show-trainer', $exercise->id) 
                                : route('exercise.show', $exercise->id);
                        @endphp

                        <!-- Card de exercício -->
                        <a href="{{ $route }}" style="background-color: #e8e2dd; border: 2px solid #feb924; border-radius: 8px; text-decoration: none; padding: 16px; transition: transform 0.2s ease; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
                            <h4 style="font-family: 'Hammersmith One', sans-serif; font-size: 1.5rem; color: #312c27; margin-bottom: 8px;">
                                {{ $exercise->title }}
                            </h4>
                            <p style="font-family: 'Clear Sans', sans-serif; font-size: 1rem; color: #312c27;">
                                {{ \Illuminate\Support\Str::limit($exercise->description, 100) }}
                            </p>
                            @if($exercise->next_due_date && Auth::user()->access_level != 'trainer')
                                <p style="font-family: 'Clear Sans', sans-serif; font-size: 0.9rem; color: #312c27; margin-top: 8px;">
                                    {{ __('Next due date:') }} {{ $exercise->next_due_date }}
                                </p>
                            @endif
                            @if($exercise->done && Auth::user()->access_level != 'trainer')
                                <p style="font-family: 'Clear Sans', sans-serif; font-size: 0.9rem; color: green; margin-top: 8px;">
                                    ✔️ {{ __('Completed') }}
                                </p>
                            @endif
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
