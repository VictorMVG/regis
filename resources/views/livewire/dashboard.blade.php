<div class="bg-white dark:bg-gray-800 relative shadow-md rounded-lg overflow-hidden">
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

            <!-- Add Buttons -->
            @hasanyrole('SUPER USUARIO|ADMINISTRADOR GENERAL|GUARDIA')
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
            @endhasanyrole

        </div>

    </div>
    <div class="p-2">
        {{ $visits->links() }}
    </div>
    <!-- Table -->
    <div class="overflow-x-auto pb-32">
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
                                    auth()->user()->hasAnyRole(['SUPER USUARIO', 'GUARDIA']) &&
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

                            @if (auth()->user()->hasAnyRole(['SUPER USUARIO', 'ADMINISTRADOR DE SEDE', 'ADMINISTRADOR GENERAL']))
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
