<x-app-layout>

    <x-form-full title="{{ __('Adding:') }} {{ __('New registration') }}" method="POST"
        action="{{ route('unit-colors.store') }}" buttonText="{{ __('Save') }}">

        <x-input-full id="name" name="name" label="{{ __('Name color') }}" required/>

    </x-form-full>

</x-app-layout>
