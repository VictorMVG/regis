<x-app-layout>

    <x-form-full title="{{ __('Adding:') }} {{ __('New registration') }}" method="POST"
        action="{{ route('users.store') }}" buttonText="{{ __('Save') }}" maxWidthClass="max-w-7xl">

        <div class="py-4 border-gray-200 sm:py-5 dark:border-gray-700">
            <!-- Inputs -->
            <div class="grid gap-4 md:gap-6 md:grid-cols-1">
                <!-- Column -->
                <div class="space-y-2 sm:space-y-4">
                    <div class="space-y-4 sm:flex sm:space-x-4 sm:space-y-0">
                        @hasanyrole('SUPER USUARIO|ADMINISTRADOR GENERAL')
                            <div class="w-full">
                                <x-select-full name="company_id" id="company_id" label="{{ __('Empresa') }}"
                                    defaultOption="Selecciona la empresa">
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}" @selected(old('company_id') == $company->id)>
                                            {{ $company->name }}
                                        </option>
                                    @endforeach
                                </x-select-full>
                            </div>
                        @endhasanyrole
                        <div class="w-full">
                            <x-select-full name="headquarter_id" id="headquarter_id" label="{{ __('Headquarter') }}"
                                defaultOption="Selecciona la sede" required>
                                @foreach ($headquarters as $headquarter)
                                    <option value="{{ $headquarter->id }}" @selected(old('headquarter_id') == $headquarter->id)>
                                        {{ $headquarter->company->name }} - {{ $headquarter->name }}
                                    </option>
                                @endforeach
                            </x-select-full>
                        </div>
                        <div class="w-full">
                            <x-input-full id="name" name="name" label="{{ __('Nombre(s)') }}" required />
                        </div>
                        <div class="w-full">
                            <x-input-full id="email" name="email" label="{{ __('Email') }}" required />
                        </div>
                    </div>

                    <div class="space-y-4 sm:flex sm:space-x-4 sm:space-y-0">
                        <div class="w-full">
                            <x-input-full id="password" name="password" type="password" label="{{ __('Password') }}"
                                required autocomplete="new-password" />
                        </div>
                        <div class="w-full">
                            <x-input-full id="password_confirmation" name="password_confirmation" type="password"
                                label="{{ __('Confirm Password') }}" required autocomplete="new-password" />
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </x-form-full>

</x-app-layout>
