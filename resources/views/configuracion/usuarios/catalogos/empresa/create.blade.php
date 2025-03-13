<x-app-layout>
    <x-form-full title="{{ __('Adding:') }} {{ __('New registration') }}" method="POST"
        action="{{ route('companies.store') }}" buttonText="{{ __('Save') }}">

        <x-input-full id="company" name="company" label="{{ __('Company') }}" required/>

        <x-input-full id="headquarter" name="headquarter" label="{{ __('Headquarter') }}" required/>

    </x-form-full>

</x-app-layout>
