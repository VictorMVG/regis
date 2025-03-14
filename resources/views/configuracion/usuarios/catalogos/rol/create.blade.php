<x-app-layout>

    <x-form-full title="{{ __('Adding:') }} {{ __('New registration') }}" method="POST"
        action="{{ route('roles.store') }}" buttonText="{{ __('Save') }}" maxWidthClass="max-w-7xl">

        <x-input-full id="name" name="name" label="{{ __('Nombre del rol') }}" required />

        @if ($permissions->count())
            <h3 class="text-sm font-medium text-gray-700 pt-5">{{ __('Permisos para asociar') }}</h3>
            <div class="grid grid-cols-1 md:grid-cols-4  gap-4 py-6">
                @foreach ($permissions as $permission)
                    <div>
                        <label for="role_{{ $permission->id }}" class="inline-flex items-center">
                            <input type="checkbox" id="role_{{ $permission->id }}" name="permissions[]"
                                value="{{ $permission->id }}" class="form-checkbox">
                            <span class="ml-2">{{ $permission->name }}</span>
                        </label>
                    </div>
                @endforeach
            </div>
        @endif

    </x-form-full>

</x-app-layout>
