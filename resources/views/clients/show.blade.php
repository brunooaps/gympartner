<x-app-layout>
    <x-slot name="header">
        <div style="background-color: #e8e2dd; padding: 16px; border-radius: 8px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
            <h1 class="text-4xl font-bold text-center" style="color: #312c27; font-family: 'Hammersmith One', sans-serif; margin: 0;">
                {{ __('Client Details') }}
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
                            <strong>{{ __('Joined at:') }}</strong>
                            {{ \Carbon\Carbon::parse($data['client']->created_at)->format('d/m/Y') }}
                        </p>
                    </div>

                    <div style="margin-top: 40px;">
                        <h4 style="font-size: 1.25rem; font-family: 'Hammersmith One', sans-serif; color: #312c27; text-align: center;">
                            {{ __('Exercises') }}
                        </h4>
                        <ul style="margin-top: 20px; padding-left: 0;">
                            @if (!empty($data['exercises']))
                                @foreach ($data['exercises'] as $index => $exercise)
                                    <li style="margin-bottom: 20px; padding: 16px; background-color: #feb924; border-radius: 8px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
                                        <h5 style="font-size: 1.25rem; font-family: 'Hammersmith One', sans-serif; color: #312c27; text-align: center;">
                                            {{ $exercise->title }}
                                        </h5>
                                        <p style="margin-top: 12px; font-family: 'Clear Sans', sans-serif; color: #312c27;">
                                            {!! nl2br(e($exercise->description)) !!}
                                        </p>
                                        <p style="margin-top: 8px; font-family: 'Clear Sans', sans-serif; color: #312c27;">
                                            <strong>{{ __('Created at:') }}</strong>
                                            {{ \Carbon\Carbon::parse($exercise->created_at)->format('d/m/Y') }}
                                        </p>
                                        @php
                                            $review = $data['reviews'][$index] ?? null;
                                        @endphp
                                        @if ($review && $review->done)
                                            <p style="margin-top: 8px; font-family: 'Clear Sans', sans-serif; color: #38a169;">
                                                {{ __('Completed at:') }}
                                                {{ \Carbon\Carbon::parse($review->done_at)->format('d/m/Y') }}
                                            </p>
                                        @else
                                            <p style="margin-top: 8px; font-family: 'Clear Sans', sans-serif; color: #e53e3e;">
                                                {{ __('Not completed yet') }}
                                            </p>
                                        @endif
                                    </li>
                                @endforeach
                            @else
                                <p style="font-family: 'Clear Sans', sans-serif; color: #312c27;">
                                    {{ __('This user has no exercises') }}
                                </p>
                                <a href="{{ route('exercise.assign', $data['client']->id) }}"
                                    style="background-color: #3b82f6; color: white; font-family: 'Clear Sans', sans-serif; font-weight: bold; padding: 12px 20px; border-radius: 8px; text-decoration: none; margin-top: 12px; display: inline-block;">
                                    {{ __('Assign Exercise') }}
                                </a>
                            @endif
                        </ul>
                    </div>
                </div>

                <!-- Botões Editar e Deletar posicionados no final -->
                <div style="margin-top: 40px; text-align: center;">
                    <a href="{{ route('client.edit', $data['client']->id) }}"
                        style="background-color: #feb924; color: white; font-family: 'Clear Sans', sans-serif; font-weight: bold; padding: 12px 16px; border-radius: 8px; text-decoration: none; margin-right: 8px;">
                        {{ __('Edit Client') }}
                    </a>
                    <form action="{{ route('client.destroy', $data['client']->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            style="background-color: #f87171; color: white; font-family: 'Clear Sans', sans-serif; font-weight: bold; padding: 12px 16px; border-radius: 8px; border: none; cursor: pointer;">
                            {{ __('Delete Client') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
