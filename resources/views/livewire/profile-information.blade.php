<x-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Profile Information') }}
    </x-slot>

    <x-slot name="description">
        {{-- {{ __('View your account\'s profile information and related details.') }} --}}
    </x-slot>

    <x-slot name="form">
        <!-- Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" value="{{ __('Name') }}" />
            <x-input id="name" type="text" class="mt-1 block w-full" value="{{ $user->name }}" disabled />
        </div>

        <!-- Email -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="email" value="{{ __('Email') }}" />
            <x-input id="email" type="email" class="mt-1 block w-full" value="{{ $user->email }}" disabled />
        </div>

        <!-- Company -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="company" value="{{ __('Administra las sedes de la empresa') }}" />
            <x-input id="company" type="text" class="mt-1 block w-full" value="{{ $user->company->name ?? 'N/A' }}"
                disabled />
        </div>

        <!-- Headquarter's Company -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="headquarter_company" value="{{ __('Esta en función de guardia en la sede') }}" />
            <x-input id="headquarter_company" type="text" class="mt-1 block w-full"
            value="{{ $user->headquarter ? $user->headquarter->company->name . ' - ' . $user->headquarter->name : 'N/A' }}" disabled />
        </div>

        <!-- Status -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="status" value="{{ __('Status') }}" />
            <x-input id="status" type="text" class="mt-1 block w-full" value="{{ $user->status->name }}"
                disabled />
        </div>
    </x-slot>
</x-form-section>
