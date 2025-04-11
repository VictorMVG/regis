<x-app-layout>
    @php
        $user = auth()->user();
        $rol = $user->roles[0]->name;
        $headquarter = $user->headquarter ? $user->headquarter->company->name . ' ' . $user->headquarter->name : 'SIN SEDE ASIGNADA';
        $company = $user->company ? $user->company->name : 'SIN EMPRESA ASIGNADA';
    @endphp

    <x-slot name="header">
        @if ($rol == 'SUPER USUARIO' || $rol == 'ADMINISTRADOR GENERAL')
            <h2>
                <span
                    class="font-semibold text-xl leading-tight bg-red-100 text-red-800 me-2 px-2.5 py-0.5 rounded-md dark:bg-red-900 dark:text-red-300">
                    {{ $rol }}
                </span>
            </h2>
        @elseif ($rol == 'ADMINISTRADOR DE SEDE')
            <span
                class="font-semibold text-xl leading-tight bg-blue-100 text-blue-800 me-2 px-2.5 py-0.5 rounded-md dark:bg-blue-900 dark:text-blue-300">
                ADMINISTRADOR DE SEDE > {{ $company }}
            </span>
        @elseif ($rol == 'GUARDIA')
            <span
                class="font-semibold text-xl leading-tight bg-green-100 text-green-800 me-2 px-2.5 py-0.5 rounded-md dark:bg-green-900 dark:text-green-300">
                GUARDIA > {{ $headquarter }}
            </span>
        @endif
    </x-slot>

    @livewire('dashboard')

    @livewire('bitacoras.bitacora.binnacleDashboard')
</x-app-layout>
