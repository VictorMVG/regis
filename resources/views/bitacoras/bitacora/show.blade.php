<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalle del registro') }}: {{ $binnacle->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-end mb-4">
                        @haspermission('IMPRIMIR BITACORA')
                            <a href="{{ route('binnacles.export-pdf', $binnacle) }}" class="flex justify-right items-right"
                                title="Imprimir" target="_blank">
                                <x-button type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="w-6 h-5 text-white mr-2" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM1.6 11.85H0v3.999h.791v-1.342h.803q.43 0 .732-.173.305-.175.463-.474a1.4 1.4 0 0 0 .161-.677q0-.375-.158-.677a1.2 1.2 0 0 0-.46-.477q-.3-.18-.732-.179m.545 1.333a.8.8 0 0 1-.085.38.57.57 0 0 1-.238.241.8.8 0 0 1-.375.082H.788V12.48h.66q.327 0 .512.181.185.183.185.522m1.217-1.333v3.999h1.46q.602 0 .998-.237a1.45 1.45 0 0 0 .595-.689q.196-.45.196-1.084 0-.63-.196-1.075a1.43 1.43 0 0 0-.589-.68q-.396-.234-1.005-.234zm.791.645h.563q.371 0 .609.152a.9.9 0 0 1 .354.454q.118.302.118.753a2.3 2.3 0 0 1-.068.592 1.1 1.1 0 0 1-.196.422.8.8 0 0 1-.334.252 1.3 1.3 0 0 1-.483.082h-.563zm3.743 1.763v1.591h-.79V11.85h2.548v.653H7.896v1.117h1.606v.638z" />
                                    </svg>
                                    {{ __('IMPRIMIR') }}
                                </x-button>
                            </a>
                        @endhaspermission
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Título -->
                        <div>
                            <strong>{{ __('Título') }}:</strong>
                            <p>{{ $binnacle->title }}</p>
                        </div>

                        <!-- Tipo de Observación -->
                        <div>
                            <strong>{{ __('Tipo de Observación') }}:</strong>
                            <p>{{ $binnacle->observationType->name }}</p>
                        </div>

                        <!-- Sede -->
                        <div>
                            <strong>{{ __('Sede') }}:</strong>
                            <p>{{ $binnacle->headquarter->name }}</p>
                        </div>

                        <!-- Usuario que creó el registro -->
                        <div>
                            <strong>{{ __('Creado por') }}:</strong>
                            <p>{{ $binnacle->user->name }}</p>
                        </div>

                        <!-- Fecha de creación -->
                        <div>
                            <strong>{{ __('Fecha de creación') }}:</strong>
                            <p>{{ $binnacle->created_at->format('d/m/Y h:i A') }}</p>
                        </div>

                    </div>

                    <!-- Observación -->
                    <div class="mt-6">
                        <strong>{{ __('Observación') }}:</strong>
                        <p class="mt-2">{{ $binnacle->observation }}</p>
                    </div>

                    <!-- Imágenes -->
                    @if ($binnacle->images && count($binnacle->images) > 0)
                        <div class="mt-6">
                            <strong>{{ __('Imágenes') }}:</strong>
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mt-4">
                                @foreach ($binnacle->images as $image)
                                    <div>
                                        <img src="{{ asset('storage/' . $image) }}" alt="Imagen"
                                            class="rounded-lg shadow-md max-h-48 cursor-pointer"
                                            onclick="openModal('{{ asset('storage/' . $image) }}')">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    <!-- Modal -->
                    <div id="imageModal"
                        class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-50">
                        <div class="relative">
                            <img id="modalImage" src="" alt="Imagen ampliada"
                                class="max-w-full max-h-screen rounded-lg shadow-lg">
                            <button onclick="closeModal()"
                                class="absolute top-4 right-4 bg-gray-800 text-white rounded-full p-2 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                &times;
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        function openModal(imageSrc) {
            const modal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');
            modalImage.src = imageSrc;
            modal.classList.remove('hidden');
        }

        function closeModal() {
            const modal = document.getElementById('imageModal');
            modal.classList.add('hidden');
        }

        // Cerrar el modal al hacer clic fuera de la imagen
        document.getElementById('imageModal').addEventListener('click', function(e) {
            if (e.target.id === 'imageModal') {
                closeModal();
            }
        });
    </script>
</x-app-layout>
