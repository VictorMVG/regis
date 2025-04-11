<div class="bg-white dark:bg-gray-800 relative shadow-md rounded-lg overflow-hidden">

    <!-- Título de la tabla -->
    <h2 class="text-2xl font-bold text-center py-4 text-gray-900 dark:text-white">
        {{ __('Bitacora del día') }}
    </h2>

    <!-- Table header -->
    <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 px-1 py-2">

        <!-- Search -->
        <div class="w-full md:w-1/2 px-2 py-1">

            <div class="relative w-full">

                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor"
                        viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <input wire:model.live.debounce.500ms="search" type="text"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500"
                    placeholder="{{ __('Search') }}">

            </div>

        </div>

        <!-- Buutons -->
        <div
            class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0 px-2 py-1">

            @haspermission('DESCARGAR EXCEL DE BITACORAS DIARIAS')
                <a href="{{ route('binnacles.export') }}">
                    <x-button type="button" color="green">
                        <svg class="h-5 w-5 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                d="M6.609 2.013A8.295 8.295 0 0 1 12 0c4.035 0 7.382 3 7.749 6.869C22.137 7.207 24 9.205 24 11.659 24 14.353 21.753 16.5 19.03 16.5H15a.75.75 0 0 1 0-1.5h4.032C20.968 15 22.5 13.482 22.5 11.659c0-1.824-1.532-3.342-3.468-3.342h-.75v-.75C18.282 4.238 15.492 1.5 12 1.5a6.795 6.795 0 0 0-4.412 1.65c-1.136.978-1.73 2.157-1.73 3.083v.672l-.668.073C3.096 7.207 1.5 8.928 1.5 11.007 1.5 13.178 3.345 15 5.672 15H9a.75.75 0 0 1 0 1.5H5.672C2.562 16.5 0 13.95 0 11.007c0-2.645 1.899-4.835 4.413-5.39.215-1.295 1.047-2.585 2.196-3.604z" />
                            <path
                                d="M11.469 23.781a.75.75 0 0 0 1.062 0l4.5-4.5a.75.75 0 0 0-1.062-1.062L12.75 21.44V8.25a.75.75 0 0 0-1.5 0v13.19l-3.219-3.22a.75.75 0 0 0-1.062 1.062z" />
                        </svg>
                        {{ __('BITACORA DEL DIA') }}
                    </x-button>
                </a>
            @endhaspermission

            @haspermission('CREAR BITACORA')
                <!-- Add Buttons -->
                <a href="{{ route('binnacles.create') }}">
                    <x-button type="button">
                        <svg class="h-5 w-5 mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 7.8v8.4M7.8 12h8.4m4.8 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        {{ __('Add') }}
                    </x-button>
                </a>
            @endhaspermission

        </div>

    </div>
    <div class="p-2">
        {{ $binnacles->links() }}
    </div>
    <!-- Table -->
    <div class="overflow-x-auto pb-32">

        <x-table>

            <x-head>
                <x-header>{{ __('Created by') }}</x-header>
                <x-header>{{ __('Observation') }}</x-header>
                <x-header>{{ __('Images') }}</x-header>
                <x-header>{{ __('Register date') }}</x-header>
                <x-header>{{ __('Acciones') }}</x-header>
            </x-head>

            <tbody>
                @foreach ($binnacles as $binnacle)
                    <x-row wire:key="{{ $binnacle->id }}">

                        <x-cell>{{ $binnacle->user->name }}</x-cell>

                        <x-cell>
                            <span
                                class="bg-blue-200 text-blue-800 text-xs font-medium me-2 px-2.5 py-2 rounded-full dark:bg-blue-900 dark:text-blue-300">
                                {{ $binnacle->headquarter->company->name }} - {{ $binnacle->headquarter->name }}
                            </span>
                            >>
                            @if ($binnacle->observationType->name === 'IMPORTANTE')
                                <span
                                    class="bg-red-300 text-red-800 text-xs font-medium me-2 px-2.5 py-2 rounded-full dark:bg-red-900 dark:text-red-500">
                                    {{ $binnacle->observationType->name }}
                                </span>
                            @else
                                <span
                                    class="bg-yellow-200 text-yellow-800 text-xs font-medium me-2 px-2.5 py-2 rounded-full dark:bg-yellow-900 dark:text-yellow-300">
                                    {{ $binnacle->observationType->name }}
                                </span>
                            @endif
                            <br><br>{{ $binnacle->observation }}
                        </x-cell>
                        <x-cell>{{ $binnacle->images ? 'SI' : 'NA' }}</x-cell>
                        <x-cell>
                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $binnacle->created_at->diffForHumans() }}
                            </span>
                            <br>
                            <span>{{ $binnacle->created_at->format('h:i A') }}</span>
                            <br>
                            <span>{{ $binnacle->created_at->format('d/m/Y') }}</span>
                        </x-cell>
                        <td class="py-2">
                            <div class="relative" x-data="{ open: false }">
                                <!-- Botón del menú -->
                                <button @click="open = !open"
                                    class="flex items-center px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-600">
                                    Opciones
                                    <svg :class="open ? 'rotate-180' : 'rotate-0'"
                                        class="w-4 h-4 ml-2 transition-transform duration-200"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                <!-- Menú desplegable -->
                                <div x-show="open" @click.away="open = false" x-cloak
                                    class="absolute right-0 mt-2 w-48 bg-gray-800 border border-gray-700 rounded-md shadow-lg z-10">
                                    <ul class="py-1 text-white">
                                        @haspermission('VER DETALLES DE LA BITACORA')
                                            <li>
                                                <a href="{{ route('binnacles.show', $binnacle) }}"
                                                    class="block px-4 py-2 hover:bg-gray-700">
                                                    Ver detalles
                                                </a>
                                            </li>
                                        @endhaspermission

                                        @haspermission('IMPRIMIR BITACORA')
                                            <li>
                                                <a href="{{ route('binnacles.export-pdf', $binnacle) }}" target="_blank"
                                                    class="block px-4 py-2 hover:bg-gray-700">
                                                    Imprimir
                                                </a>
                                            </li>
                                        @endhaspermission

                                        @hasanyrole('SUPER USUARIO|ADMINISTRADOR GENERAL|ADMINISTRADOR DE SEDE')
                                            @haspermission('EDITAR BITACORA')
                                                <li>
                                                    <a href="{{ route('binnacles.edit', $binnacle) }}"
                                                        class="block px-4 py-2 hover:bg-gray-700">
                                                        Editar
                                                    </a>
                                                </li>
                                            @endhaspermission
                                        @else
                                            @hasrole('GUARDIA')
                                                @if ($binnacle->user_id === auth()->id())
                                                    @haspermission('EDITAR BITACORA')
                                                        <li>
                                                            <a href="{{ route('binnacles.edit', $binnacle) }}"
                                                                class="block px-4 py-2 hover:bg-gray-700">
                                                                Editar
                                                            </a>
                                                        </li>
                                                    @endhaspermission
                                                @endif
                                            @endhasrole
                                        @endhasanyrole

                                        @haspermission('ELIMINAR BITACORA')
                                            <li>
                                                <form id="delete-form-{{ $binnacle->id }}"
                                                    action="{{ route('binnacles.destroy', $binnacle) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                        onclick="confirmDelete('delete-form-{{ $binnacle->id }}')"
                                                        class="block w-full text-left px-4 py-2 hover:bg-red-700">
                                                        Eliminar
                                                    </button>
                                                </form>
                                            </li>
                                        @endhaspermission
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </x-row>
                @endforeach

            </tbody>

        </x-table>

        <div class="p-4">
            {{ $binnacles->links() }}
        </div>

    </div>
</div>
