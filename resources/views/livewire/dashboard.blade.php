<div class="bg-white dark:bg-gray-800 relative shadow-md rounded-lg overflow-hidden">

    <!-- Título de la tabla -->
    <h2 class="text-2xl font-bold text-center py-4 text-gray-900 dark:text-white">
        {{ __('Registros de visitas diarias') }}
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

            @haspermission('DESCARGAR EXCEL DE VISITAS DIARIAS')
                <a href="{{ route('visits.export') }}">
                    <x-button type="button" color="green">
                        <svg class="h-5 w-5 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                d="M6.609 2.013A8.295 8.295 0 0 1 12 0c4.035 0 7.382 3 7.749 6.869C22.137 7.207 24 9.205 24 11.659 24 14.353 21.753 16.5 19.03 16.5H15a.75.75 0 0 1 0-1.5h4.032C20.968 15 22.5 13.482 22.5 11.659c0-1.824-1.532-3.342-3.468-3.342h-.75v-.75C18.282 4.238 15.492 1.5 12 1.5a6.795 6.795 0 0 0-4.412 1.65c-1.136.978-1.73 2.157-1.73 3.083v.672l-.668.073C3.096 7.207 1.5 8.928 1.5 11.007 1.5 13.178 3.345 15 5.672 15H9a.75.75 0 0 1 0 1.5H5.672C2.562 16.5 0 13.95 0 11.007c0-2.645 1.899-4.835 4.413-5.39.215-1.295 1.047-2.585 2.196-3.604z" />
                            <path
                                d="M11.469 23.781a.75.75 0 0 0 1.062 0l4.5-4.5a.75.75 0 0 0-1.062-1.062L12.75 21.44V8.25a.75.75 0 0 0-1.5 0v13.19l-3.219-3.22a.75.75 0 0 0-1.062 1.062z" />
                        </svg>
                        {{ __('VISITAS DEL DIA') }}
                    </x-button>
                </a>
            @endhaspermission

            @haspermission('CREAR VISITA')
                <!-- Add Buttons -->
                <a href="{{ route('visits.create') }}">
                    <x-button type="button" color="green">
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
        {{ $visits->links() }}
    </div>
    <!-- Table -->
    <div class="overflow-x-auto pb-5">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-4 py-3">
                        {{ __('Name and company') }}
                    </th>
                    <th scope="col" class="px-4 py-3 text-wrap">
                        {{ __('Visit reason') }}
                    </th>
                    <th scope="col" class="px-4 py-3">
                        {{ __('Alcohol test') }}
                    </th>
                    <th scope="col" class="px-4 py-3">
                        {{ __('Unit') }}
                    </th>
                    <th scope="col" class="px-4 py-3">
                        {{ __('Entry time') }}
                    </th>
                    <th scope="col" class="px-4 py-3">
                        {{ __('Exit time') }}
                    </th>
                    <th scope="col" class="px-4 py-3">
                        <span class="sr-only">
                            Actions
                        </span>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($visits as $visit)
                    <tr wire:key="{{ $visit->id }}"
                        class="border-b dark:border-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600">
                        <th scope="row" class="px-4 py-3 font-medium text-gray-900 text-wrap dark:text-white">
                            {{ $visit->visitor_name }}
                            <br>
                            {{ $visit->company_name }}
                        </th>
                        <th scope="row" class="px-4 py-3 font-medium text-gray-900 text-wrap dark:text-white">
                            <span class=" font-extrabold text-xs text-gray-500 dark:text-gray-400">PARA:</span>
                            {{ $visit->reason }}
                            <br>
                            <span class=" font-extrabold text-xs text-gray-500 dark:text-gray-400">CON:</span>
                            {{ $visit->to_see }}
                        </th>
                        <th scope="row" class="px-4 py-3 font-medium text-gray-900 text-wrap dark:text-white">
                            {{ $visit->alcohol_test ? 'POSITIVO' : 'NEGATIVO' }}
                        </th>
                        <th scope="row" class="px-4 py-3 font-medium text-gray-900 text-wrap dark:text-white">
                            {{ $visit->unit ? 'SI' : 'NA' }}
                        </th>
                        <th scope="row"
                            class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $visit->created_at->diffForHumans() }}
                            </span>
                            <br>
                            <span>{{ $visit->created_at->format('h:i A') }}</span>
                            <br>
                            <span>{{ $visit->created_at->format('d/m/Y') }}</span>
                        </th>
                        <th scope="row"
                            class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $visit->exit_time ? $visit->exit_time->diffForHumans() : '-' }}
                            </span>
                            <br>
                            <span>{{ $visit->exit_time ? $visit->exit_time->format('h:i A') : '-' }}</span>
                            <br>
                            <span>{{ $visit->exit_time ? $visit->exit_time->format('d/m/Y') : '-' }}</span>
                        </th>
                        <td class="px-4 py-2 flex items-center justify-center relative" x-data="{ open: {}, up: false }">

                            <!-- Ícono para actualizar exit_time -->
                            @if (
                                !$visit->exit_time &&
                                    auth()->user()->hasAnyRole(['SUPER USUARIO', 'ADMINISTRADOR GENERAL', 'ADMINISTRADOR DE SEDE', 'GUARDIA']) &&
                                    $visit->created_at->isToday())
                                <form action="{{ route('visits.updateExitTime', $visit->id) }}" method="POST"
                                    class="ml-2">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-800 dark:text-white hover:text-blue-500 dark:hover:text-blue-400 rotate-180"
                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M20 12H8m12 0-4 4m4-4-4-4M9 4H7a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h2" />
                                        </svg>
                                    </button>
                                </form>
                            @endif

                            @if (auth()->user()->hasAnyRole(['SUPER USUARIO', 'ADMINISTRADOR GENERAL ', 'ADMINISTRADOR DE SEDE']))
                                <x-action-td :id="$visit->id" :routes="[
                                    ['name' => 'Edit', 'route' => 'visits.edit'],
                                    ['name' => 'Destroy', 'route' => 'visits.destroy', 'method' => 'DELETE'],
                                ]" />
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4">
            {{ $visits->links() }}
        </div>
    </div>
</div>
