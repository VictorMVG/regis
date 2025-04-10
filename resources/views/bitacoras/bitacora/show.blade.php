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
                                        <img src="{{ asset('storage/' . $image) }}" alt="Imagen" class="rounded-lg shadow-md">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>