<x-app-layout>
    <x-form-full title="{{ __('Editing:') }} {{ $company->name }}" method="PUT"
        action="{{ route('companies.update', $company) }}" buttonText="{{ __('Update') }}">

        <x-input-full id="name" name="name" label="{{ __('Name') }}" defaultValue="{{ $company->name }}"
            required />

        <x-input-full id="alias" name="alias" label="{{ __('Abreviation') }}"
            defaultValue="{{ $company->alias }}" required />

        <x-select-full name="status_id" id="status_id" label="{{ __('Status') }}"
            defaultValue="{{ $company->status_id }}" required>
            @foreach ($statuses as $status)
                <option value="{{ $status->id }}" @selected(old('status_id', $company->status_id) == $status->id)>{{ $status->name }}</option>
            @endforeach
        </x-select-full>

    </x-form-full>

</x-app-layout>
