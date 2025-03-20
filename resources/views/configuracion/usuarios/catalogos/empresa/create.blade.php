<x-app-layout>
    <x-form-full title="{{ __('Adding:') }} {{ __('New registration') }}" method="POST"
        action="{{ route('companies.store') }}" buttonText="{{ __('Save') }}">

        <x-input-full id="name" name="name" label="{{ __('Name') }}" required/>

        <x-input-full id="alias" name="alias" label="{{ __('Abreviation') }}"/>

    </x-form-full>

</x-app-layout>
