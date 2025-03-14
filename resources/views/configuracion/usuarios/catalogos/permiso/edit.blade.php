<x-app-layout>

    <x-form-full title="{{ __('Editing:') }} {{ $permission->name }}" method="PUT"
        action="{{ route('permissions.update', $permission) }}" buttonText="{{ __('Update') }}"  maxWidthClass="max-w-7xl">

        <x-input-full id="name" name="name" label="{{ __('Nombre del permiso') }}"
            defaultValue="{{ $permission->name }}" required />

        @if ($roles->count())
        <h3 class="text-sm font-medium text-gray-700 pt-5">{{ __('Roles asociados') }}</h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 py-6 px-2">
                @foreach ($roles as $role)
                    <div>
                        <label for="role_{{ $role->id }}" class="inline-flex items-center">
                            <input type="checkbox" id="role_{{ $role->id }}" name="roles[]"
                                value="{{ $role->id }}" class="form-checkbox"
                                {{ $permission->roles->contains($role->id) ? 'checked' : '' }}>
                            <span class="ml-2">{{ $role->name }}</span>
                        </label>
                    </div>
                @endforeach
            </div>
        @endif

    </x-form-full>

</x-app-layout>
