<x-app-layout>

    <x-form-full title="{{ __('Adding:') }} {{ __('New registration') }}" method="POST"
        action="{{ route('permissions.store') }}" buttonText="{{ __('Save') }}" maxWidthClass="max-w-7xl">

        {{-- campo de texto para el nombre del permiso --}}

        <x-input-full id="name" name="name" label="{{ __('Nombre del permiso') }}" required />

        {{-- lista de roles en checkbox para seleccionar a que rol se le asignara el permiso en caso de haber roles si no no mostrara nada y este campo no sera requerido --}}
        @if ($roles->count())
        <h3 class="text-sm font-medium text-gray-700 pt-5">{{ __('Roles para asociar') }}</h3>
            <div class="grid grid-cols-4 gap-4 py-6">
                @foreach ($roles as $role)
                    <div>
                        <label for="role_{{ $role->id }}" class="inline-flex items-center">
                            <input type="checkbox" id="role_{{ $role->id }}" name="roles[]"
                                value="{{ $role->id }}" class="form-checkbox">
                            <span class="ml-2">{{ $role->name }}</span>
                        </label>
                    </div>
                @endforeach
            </div>
        @endif

    </x-form-full>

</x-app-layout>
