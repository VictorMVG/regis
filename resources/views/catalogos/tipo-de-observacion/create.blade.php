<x-app-layout>

    <x-form-full title="{{ __('Adding:') }} {{ __('New registration') }}" method="POST"
        action="{{ route('observation-types.store') }}" buttonText="{{ __('Save') }}">

        <x-input-full id="name" name="name" label="{{ __('Name observation type') }}" required/>

    </x-form-full>

</x-app-layout>
