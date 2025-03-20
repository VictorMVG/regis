<x-app-layout>
    <x-form-full title="{{ __('Adding:') }} {{ __('New registration') }}" method="POST"
        action="{{ route('headquarters.store') }}" buttonText="{{ __('Save') }}">

        @hasanyrole('SUPER USUARIO|ADMINISTRADOR GENERAL')
            <x-select-full name="company_id" id="company_id" label="{{ __('Empresa') }}" defaultOption="Selecciona la empresa" required>
                @foreach ($companies as $company)
                    <option value="{{ $company->id }}" @selected(old('company_id') == $company->id)>
                        {{ $company->name }}</option>
                @endforeach
            </x-select-full>
        @endhasanyrole

        <x-input-full id="name" name="name" label="{{ __('Name') }}" required />

        <x-textarea-full id="description" name="description" label="{{ __('Descripción') }}" />

    </x-form-full>

</x-app-layout>
