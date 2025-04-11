<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalle de la Visita') }}: {{ $visit->visitor_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Nombre del visitante -->
                        <div>
                            <strong>{{ __('Nombre del Visitante') }}:</strong>
                            <p>{{ $visit->visitor_name }}</p>
                        </div>

                        <!-- Nombre de la empresa -->
                        <div>
                            <strong>{{ __('Nombre de la Empresa') }}:</strong>
                            <p>{{ $visit->company_name }}</p>
                        </div>

                        <!-- Razón de la visita -->
                        <div>
                            <strong>{{ __('Razón de la Visita') }}:</strong>
                            <p>{{ $visit->reason }}</p>
                        </div>

                        <!-- Persona a ver -->
                        <div>
                            <strong>{{ __('Persona a Ver') }}:</strong>
                            <p>{{ $visit->to_see }}</p>
                        </div>

                        <!-- Prueba de alcohol -->
                        <div>
                            <strong>{{ __('Prueba de Alcohol') }}:</strong>
                            <p>{{ $visit->alcohol_test ? 'Sí' : 'No' }}</p>
                        </div>

                        <!-- Unidad -->
                        <div>
                            <strong>{{ __('Unidad') }}:</strong>
                            <p>{{ $visit->unit ? 'Sí' : 'No' }}</p>
                        </div>

                        <!-- Placa de la unidad -->
                        @if ($visit->unit_plate)
                            <div>
                                <strong>{{ __('Placa de la Unidad') }}:</strong>
                                <p>{{ $visit->unit_plate }}</p>
                            </div>
                        @endif

                        <!-- Tipo de unidad -->
                        @if ($visit->unitType)
                            <div>
                                <strong>{{ __('Tipo de Unidad') }}:</strong>
                                <p>{{ $visit->unitType->name }}</p>
                            </div>
                        @endif

                        <!-- Modelo de la unidad -->
                        @if ($visit->unit_model)
                            <div>
                                <strong>{{ __('Modelo de la Unidad') }}:</strong>
                                <p>{{ $visit->unit_model }}</p>
                            </div>
                        @endif

                        <!-- Número de la unidad -->
                        @if ($visit->unit_number)
                            <div>
                                <strong>{{ __('Número de la Unidad') }}:</strong>
                                <p>{{ $visit->unit_number }}</p>
                            </div>
                        @endif

                        <!-- Color de la unidad -->
                        @if ($visit->unitColor)
                            <div>
                                <strong>{{ __('Color de la Unidad') }}:</strong>
                                <p>{{ $visit->unitColor->name }}</p>
                            </div>
                        @endif

                        <!-- Comentarios -->
                        @if ($visit->comment)
                            <div>
                                <strong>{{ __('Comentarios') }}:</strong>
                                <p>{{ $visit->comment }}</p>
                            </div>
                        @endif

                        <!-- Sede -->
                        <div>
                            <strong>{{ __('Sede') }}:</strong>
                            <p>{{ $visit->headquarter->name }}</p>
                        </div>

                        <!-- Usuario que registró -->
                        <div>
                            <strong>{{ __('Registrado por') }}:</strong>
                            <p>{{ $visit->user->name }}</p>
                        </div>

                        <!-- Fecha de creación -->
                        <div>
                            <strong>{{ __('Fecha de Registro') }}:</strong>
                            <p>{{ $visit->created_at->format('d/m/Y h:i A') }}</p>
                        </div>

                        <!-- Hora de salida -->
                        @if ($visit->exit_time)
                            <div>
                                <strong>{{ __('Hora de Salida') }}:</strong>
                                <p>{{ $visit->exit_time->format('d/m/Y h:i A') }}</p>
                            </div>
                        @endif

                        <!-- Última actualización -->
                        @if ($visit->updatedBy)
                            <div>
                                <strong>{{ __('Última Actualización por') }}:</strong>
                                <p>{{ $visit->updatedBy->name }}</p>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>