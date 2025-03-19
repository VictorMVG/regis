<x-app-layout>

    <x-form-full title="{{ __('Adding:') }} {{ __('New registration') }}" method="POST"
        action="{{ route('unit-types.store') }}" buttonText="{{ __('Save') }}">

        <x-input-full id="name" name="name" label="{{ __('Name unit type') }}" required/>

    </x-form-full>

</x-app-layout>
