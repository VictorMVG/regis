<x-app-layout>
    <x-form-full title="{{ __('Editing:') }} {{ $company->company }} - {{ $company->headquarter }}" method="PUT"
        action="{{ route('companies.update', $company) }}" buttonText="{{ __('Update') }}">

        <x-input-full id="company" name="company" label="{{ __('Company') }}" defaultValue="{{ $company->company }}"
            required />

        <x-input-full id="headquarter" name="headquarter" label="{{ __('Headquarter') }}"
            defaultValue="{{ $company->headquarter }}" required />

        <x-select-full name="status_id" id="status_id" label="{{ __('Status') }}"
            defaultValue="{{ $company->status_id }}" required>
            @foreach ($statuses as $status)
                <option value="{{ $status->id }}" @selected(old('status_id', $company->status_id) == $status->id)>{{ $status->name }}</option>
            @endforeach
        </x-select-full>

    </x-form-full>

</x-app-layout>
