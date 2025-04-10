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
            <a href="{{ route('companies.create') }}">
                <x-button type="button">
                    <svg class="h-5 w-5 mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 7.8v8.4M7.8 12h8.4m4.8 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    {{ __('Add') }}
                </x-button>
            </a>

        </div>

    </div>
    <div class="p-2">
        {{ $companies->links() }}
    </div>
    <!-- Table -->
    <div class="overflow-x-auto pb-32">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <x-head>
                <x-header>{{ __('Name') }}</x-header>
                <x-header>{{ __('Abreviation') }}</x-header>
                <x-header>{{ __('Status') }}</x-header>
                <x-header>
                    <span class="sr-only">
                        Actions
                    </span>
                </x-header>
            </x-head>
            <tbody>
                @foreach ($companies as $company)
                    <tr wire:key="{{ $company->id }}"
                        class="border-b dark:border-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600">
                        <th scope="row"
                            class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $company->name }}
                        </th>
                        <th scope="row"
                            class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $company->alias }}
                        </th>
                        <th scope="row"
                            class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $company->status->name }}
                        </th>
                        {{-- <td class="px-4 py-3 flex items-center justify-center relative" x-data="{ open: {}, up: false }">
                            <x-action-td :id="$company->id" :routes="[
                                ['name' => 'Edit', 'route' => 'companies.edit'],
                                ['name' => 'Destroy', 'route' => 'companies.destroy', 'method' => 'DELETE'],
                            ]" />
                        </td> --}}
                        <td class="py-2">
                            <div class="flex flex-wrap justify-between items-center">
                                {{-- @haspermission('VER DETALLES DE LA BITACORA')
                                    <a href="{{ route('companies.show', $company) }}"
                                        class="flex justify-center items-center w-1/2" title="Ver detalles">
                                        <svg class="w-6 h-6 text-gray-700 hover:text-green-600 dark:text-white"
                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd"
                                                d="M4.998 7.78C6.729 6.345 9.198 5 12 5c2.802 0 5.27 1.345 7.002 2.78a12.713 12.713 0 0 1 2.096 2.183c.253.344.465.682.618.997.14.286.284.658.284 1.04s-.145.754-.284 1.04a6.6 6.6 0 0 1-.618.997 12.712 12.712 0 0 1-2.096 2.183C17.271 17.655 14.802 19 12 19c-2.802 0-5.27-1.345-7.002-2.78a12.712 12.712 0 0 1-2.096-2.183 6.6 6.6 0 0 1-.618-.997C2.144 12.754 2 12.382 2 12s.145-.754.284-1.04c.153-.315.365-.653.618-.997A12.714 12.714 0 0 1 4.998 7.78ZM12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                @endhaspermission --}}

                                @if (auth()->user()->hasRole(['SUPER USUARIO', 'ADMINISTRADOR GENERAL', 'ADMINISTRADOR DE SEDE']) ||
                                        $company->user_id === auth()->id())
                                    @haspermission('EDITAR EMPRESA')
                                        <a href="{{ route('companies.edit', $company) }}"
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

                                @haspermission('ELIMINAR EMPRESA')
                                    <form id="delete-form-{{ $company->id }}"
                                        action="{{ route('companies.destroy', $company) }}" method="POST"
                                        class="flex justify-center items-center w-1/2" title="Eliminar">
                                        @csrf
                                        @method('DELETE')

                                        <button type="button" onclick="confirmDelete('delete-form-{{ $company->id }}')"
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
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4">
            {{ $companies->links() }}
        </div>
    </div>
</div>
