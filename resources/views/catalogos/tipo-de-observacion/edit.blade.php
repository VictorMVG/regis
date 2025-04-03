<x-app-layout>

    <x-form-full title="{{ __('Editing:') }} {{ $observationType->name }}" method="PUT"
        action="{{ route('observation-types.update', $observationType) }}" buttonText="{{ __('Update') }}">

        <x-input-full id="name" name="name" label="{{ __('Name observation type') }}" defaultValue="{{ $observationType->name }}"
            required />

    </x-form-full>

</x-app-layout>
