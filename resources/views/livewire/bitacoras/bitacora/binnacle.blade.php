<div class="bg-white dark:bg-gray-800 relative shadow-md rounded-lg overflow-hidden">

    <!-- Título de la tabla -->
    <h2 class="text-2xl font-bold text-center py-4 text-gray-900 dark:text-white">
        {{ __('Registros de la bítacora') }}
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
                <x-button type="button" color="green" wire:click="export">
                    <svg class="h-5 w-5 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            d="M6.609 2.013A8.295 8.295 0 0 1 12 0c4.035 0 7.382 3 7.749 6.869C22.137 7.207 24 9.205 24 11.659 24 14.353 21.753 16.5 19.03 16.5H15a.75.75 0 0 1 0-1.5h4.032C20.968 15 22.5 13.482 22.5 11.659c0-1.824-1.532-3.342-3.468-3.342h-.75v-.75C18.282 4.238 15.492 1.5 12 1.5a6.795 6.795 0 0 0-4.412 1.65c-1.136.978-1.73 2.157-1.73 3.083v.672l-.668.073C3.096 7.207 1.5 8.928 1.5 11.007 1.5 13.178 3.345 15 5.672 15H9a.75.75 0 0 1 0 1.5H5.672C2.562 16.5 0 13.95 0 11.007c0-2.645 1.899-4.835 4.413-5.39.215-1.295 1.047-2.585 2.196-3.604z" />
                        <path
                            d="M11.469 23.781a.75.75 0 0 0 1.062 0l4.5-4.5a.75.75 0 0 0-1.062-1.062L12.75 21.44V8.25a.75.75 0 0 0-1.5 0v13.19l-3.219-3.22a.75.75 0 0 0-1.062 1.062z" />
                    </svg>
                    {{ __('DESCARGAR EXCEL') }}
                </x-button>
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
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">

            <x-head>
                <x-header>{{ __('Created by') }}</x-header>
                <x-header>{{ __('Observation') }}</x-header>
                <x-header>{{ __('Images') }}</x-header>
                <x-header>{{ __('Register date') }}</x-header>
                <x-header>{{ __('Acciones') }}</x-header>
            </x-head>

            <tbody>
                @foreach ($binnacles as $binnacle)
                    <tr wire:key="{{ $binnacle->id }}"
                        class="border-b dark:border-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600">
                        <th scope="row"
                            class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $binnacle->user->name }}
                        </th>
                        <th scope="row" class="px-4 py-3 font-medium text-gray-900 text-wrap dark:text-white">
                            <span
                                class="bg-blue-200 text-blue-800 text-xs font-medium me-2 px-2.5 py-2 rounded-full dark:bg-blue-900 dark:text-blue-300">
                                {{ $binnacle->headquarter->company->name }} - {{ $binnacle->headquarter->name }}
                            </span>
                            >> @if ($binnacle->observationType->name === 'IMPORTANTE')
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
                            <br> <br>
                            {{ $binnacle->observation }}
                        </th>
                        <th scope="row" class="px-4 py-3 font-medium text-gray-900 text-wrap dark:text-white">
                            {{ $binnacle->images ? 'SI' : 'NA' }}
                        </th>
                        <th scope="row"
                            class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $binnacle->created_at->diffForHumans() }}
                            </span>
                            <br>
                            <span>{{ $binnacle->created_at->format('h:i A') }}</span>
                            <br>
                            <span>{{ $binnacle->created_at->format('d/m/Y') }}</span>
                        </th>

                        {{-- <td class="py-2">
                            <div class="flex flex-wrap justify-between items-center">
                                @haspermission('VER DETALLES DE LA BITACORA')
                                    <a href="{{ route('binnacles.show', $binnacle) }}"
                                        class="flex justify-center items-center w-1/2" title="Ver detalles">
                                        <svg class="w-6 h-6 text-gray-700 hover:text-green-600 dark:text-white"
                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd"
                                                d="M4.998 7.78C6.729 6.345 9.198 5 12 5c2.802 0 5.27 1.345 7.002 2.78a12.713 12.713 0 0 1 2.096 2.183c.253.344.465.682.618.997.14.286.284.658.284 1.04s-.145.754-.284 1.04a6.6 6.6 0 0 1-.618.997 12.712 12.712 0 0 1-2.096 2.183C17.271 17.655 14.802 19 12 19c-2.802 0-5.27-1.345-7.002-2.78a12.712 12.712 0 0 1-2.096-2.183 6.6 6.6 0 0 1-.618-.997C2.144 12.754 2 12.382 2 12s.145-.754.284-1.04c.153-.315.365-.653.618-.997A12.714 12.714 0 0 1 4.998 7.78ZM12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                @endhaspermission


                                @haspermission('IMPRIMIR BITACORA')
                                    <a href="{{ route('binnacles.export-pdf', $binnacle) }}"
                                        class="flex justify-center items-center w-1/2" title="Imprimir" target="_blank">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor"
                                            class="w-6 h-5 text-gray-700 hover:text-yellow-600 dark:text-white"
                                            viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM1.6 11.85H0v3.999h.791v-1.342h.803q.43 0 .732-.173.305-.175.463-.474a1.4 1.4 0 0 0 .161-.677q0-.375-.158-.677a1.2 1.2 0 0 0-.46-.477q-.3-.18-.732-.179m.545 1.333a.8.8 0 0 1-.085.38.57.57 0 0 1-.238.241.8.8 0 0 1-.375.082H.788V12.48h.66q.327 0 .512.181.185.183.185.522m1.217-1.333v3.999h1.46q.602 0 .998-.237a1.45 1.45 0 0 0 .595-.689q.196-.45.196-1.084 0-.63-.196-1.075a1.43 1.43 0 0 0-.589-.68q-.396-.234-1.005-.234zm.791.645h.563q.371 0 .609.152a.9.9 0 0 1 .354.454q.118.302.118.753a2.3 2.3 0 0 1-.068.592 1.1 1.1 0 0 1-.196.422.8.8 0 0 1-.334.252 1.3 1.3 0 0 1-.483.082h-.563zm3.743 1.763v1.591h-.79V11.85h2.548v.653H7.896v1.117h1.606v.638z" />
                                        </svg>
                                    </a>
                                @endhaspermission

                                @if (auth()->user()->hasRole(['SUPER USUARIO', 'ADMINISTRADOR GENERAL', 'ADMINISTRADOR DE SEDE']) ||
                                        $binnacle->user_id === auth()->id())
                                    @haspermission('EDITAR BITACORA')
                                        <a href="{{ route('binnacles.edit', $binnacle) }}"
                                            class="flex justify-center items-center w-1/2" title="Editar">
                                            <svg class="w-6 h-6 text-gray-700 hover:text-cyan-600 dark:text-white"
                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd"
                                                    d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z"
                                                    clip-rule="evenodd" />
                                                <path fill-rule="evenodd"
                                                    d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    @endhaspermission
                                @endif

                                <br> <br>

                                @haspermission('ELIMINAR BITACORA')
                                    <form id="delete-form-{{ $binnacle->id }}"
                                        action="{{ route('binnacles.destroy', $binnacle) }}" method="POST"
                                        class="flex justify-center items-center w-1/2" title="Eliminar">
                                        @csrf
                                        @method('DELETE')

                                        <button type="button" onclick="confirmDelete('delete-form-{{ $binnacle->id }}')"
                                            class="text-gray-700 hover:text-red-600">
                                            <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd"
                                                    d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </form>
                                @endhaspermission
                            </div>
                        </td> --}}

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

                                        @haspermission('EDITAR BITACORA')
                                            <li>
                                                <a href="{{ route('binnacles.edit', $binnacle) }}"
                                                    class="block px-4 py-2 hover:bg-gray-700">
                                                    Editar
                                                </a>
                                            </li>
                                        @endhaspermission

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

                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4">
            {{ $binnacles->links() }}
        </div>
    </div>
</div>
