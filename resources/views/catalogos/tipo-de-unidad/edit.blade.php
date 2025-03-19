<x-app-layout>

    <x-form-full title="{{ __('Editing:') }} {{ $unitType->name }}" method="PUT"
        action="{{ route('unit-types.update', $unitType) }}" buttonText="{{ __('Update') }}">

        <x-input-full id="name" name="name" label="{{ __('Name unit type') }}" defaultValue="{{ $unitType->name }}"
            required />

    </x-form-full>

</x-app-layout>
