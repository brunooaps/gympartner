<nav x-data="{ open: false }" style="background-color: #312c27; border-bottom: 2px solid #feb924;">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Logo -->
            <div class="shrink-0 flex items-center">
                <a href="{{ route('exercises') }}" style="text-decoration: none;">
                    <x-application-logo class="block h-9 w-auto" style="fill: #feb924;" />
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="hidden sm:flex space-x-6 items-center">
                <a href="{{ route('exercises') }}" style="font-family: 'Hammersmith One', sans-serif; color: #feb924; font-size: 1.2rem; text-decoration: none; padding: 8px 12px; border-radius: 8px; transition: background-color 0.2s;"
                    :class="{'bg-amber-500': request()->routeIs('exercises')}">
                    {{ __('Exercícios') }}
                </a>

                @if(Auth::user()->access_level == 'trainer')
                    <a href="{{ route('client.index') }}" style="font-family: 'Hammersmith One', sans-serif; color: #feb924; font-size: 1.2rem; text-decoration: none; padding: 8px 12px; border-radius: 8px; transition: background-color 0.2s;"
                        :class="{'bg-amber-500': request()->routeIs('client.index')}">
                        {{ __('Clientes') }}
                    </a>
                @endif
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button style="font-family: 'Clear Sans', sans-serif; background-color: #feb924; color: #312c27; padding: 8px 12px; border-radius: 8px; font-size: 1rem; display: flex; align-items: center; transition: transform 0.2s;">
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="ml-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" style="font-family: 'Clear Sans', sans-serif;">
                            {{ __('Perfil') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();" style="font-family: 'Clear Sans', sans-serif;">
                                {{ __('Sair') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="sm:hidden">
                <button @click="open = ! open" style="color: #feb924; background: none; border: none; font-size: 1.5rem;">
                    ☰
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div style="background-color: #312c27; color: #feb924; font-family: 'Clear Sans', sans-serif;">
            <a href="{{ route('exercises') }}" class="block px-4 py-2">{{ __('Exercícios') }}</a>
            @if(Auth::user()->access_level == 'trainer')
                <a href="{{ route('client.index') }}" class="block px-4 py-2">{{ __('Clientes') }}</a>
            @endif
            <a href="{{ route('profile.edit') }}" class="block px-4 py-2">{{ __('Perfil') }}</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="block w-full text-left px-4 py-2">{{ __('Sair') }}</button>
            </form>
        </div>
    </div>
</nav>
