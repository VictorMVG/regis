<x-app-layout>
    <x-form-full title="{{ __('Editing:') }} {{ $headquarter->name }} de {{ $headquarter->company->name }}" method="PUT"
        action="{{ route('headquarters.update', $headquarter) }}" buttonText="{{ __('Update') }}">

        @hasanyrole('SUPER USUARIO')
            <x-select-full name="company_id" id="company_id" label="{{ __('Company') }}"
                defaultValue="{{ $headquarter->company_id }}">
                @foreach ($companies as $company)
                    <option value="{{ $company->id }}" @selected(old('company_id', $headquarter->company_id) == $company->id)>
                        {{ $company->name }}
                    </option>
                @endforeach
            </x-select-full>
        @endhasanyrole

        <x-input-full id="name" name="name" label="{{ __('Name') }}" defaultValue="{{ $headquarter->name }}"
            required />

        <x-textarea-full name="description" label="{{ __('Descripción') }}" placeholder="Escribe aquí..."
            :defaultValue="$headquarter->description" />

        <x-select-full name="status_id" id="status_id" label="{{ __('Status') }}"
            defaultValue="{{ $headquarter->status_id }}" required>
            @foreach ($statuses as $status)
                <option value="{{ $status->id }}" @selected(old('status_id', $headquarter->status_id) == $status->id)>{{ $status->name }}</option>
            @endforeach
        </x-select-full>

    </x-form-full>

</x-app-layout>
