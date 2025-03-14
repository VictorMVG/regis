<x-app-layout>

    <x-form-full title="{{ __('Editing:') }} {{ $role->name }}" method="PUT"
        action="{{ route('roles.update', $role) }}" buttonText="{{ __('Update') }}" maxWidthClass="max-w-7xl">

        <x-input-full id="name" name="name" label="{{ __('Nombre del rol') }}" defaultValue="{{ $role->name }}"
            required />

        @if ($permissions->count())
            <h3 class="text-sm font-medium text-gray-700 pt-5">{{ __('Permisos asociados') }}</h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 py-6 px-2">
                @foreach ($permissions as $permission)
                    <div>
                        <label for="permission_{{ $permission->id }}" class="inline-flex items-center">
                            <input type="checkbox" id="permission_{{ $permission->id }}" name="permissions[]"
                                value="{{ $permission->id }}" class="form-checkbox"
                                {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}>
                            <span class="ml-2">{{ $permission->name }}</span>
                        </label>
                    </div>
                @endforeach
            </div>
        @endif

    </x-form-full>

</x-app-layout>
