<x-app-layout>

    <x-form-full title="{{ __('Editing:') }} {{ $unitColor->name }}" method="PUT"
        action="{{ route('unit-colors.update', $unitColor) }}" buttonText="{{ __('Update') }}">

        <x-input-full id="name" name="name" label="{{ __('Name color') }}" defaultValue="{{ $unitColor->name }}"
            required />

    </x-form-full>

</x-app-layout>
