<x-app-layout>

    <x-form-full title="{{ __('Adding:') }} {{ __('New registration') }}" method="POST"
        action="{{ route('users.store') }}" buttonText="{{ __('Save') }}" maxWidthClass="max-w-7xl">

        <div class="py-4 border-gray-200 sm:py-5 dark:border-gray-700">
            <!-- Inputs -->
            <div class="grid gap-4 md:gap-6 md:grid-cols-1">
                <!-- Column -->
                <div class="space-y-2 sm:space-y-4">
                    <div class="space-y-4 sm:flex sm:space-x-4 sm:space-y-0">
                        <div class="w-full">
                            <x-select-full name="unit_color_id" id="unit_color_id" label="{{ __('Empresa') }}"
                                defaultOption="Selecciona la empresa">
                                @foreach ($unitColors as $unitColor)
                                    <option value="{{ $unitColor->id }}" @selected(old('unit_color_id') == $unitColor->id)>
                                        {{ $unitColor->name }}
                                    </option>
                                @endforeach
                            </x-select-full>
                        </div>
                        <div class="w-full">
                            <x-select-full name="unit_type_id" id="unit_type_id" label="{{ __('unitType') }}"
                                defaultOption="Selecciona la sede" required>
                                @foreach ($unitTypes as $unitType)
                                    <option value="{{ $unitType->id }}" @selected(old('unit_type_id') == $unitType->id)>
                                        {{ $unitType->company->name }} - {{ $unitType->name }}
                                    </option>
                                @endforeach
                            </x-select-full>
                        </div>
                    </div>

                    <div class="space-y-4 sm:flex sm:space-x-4 sm:space-y-0">
                        <div class="w-full">
                            <x-input-full id="visitor_name" name="visitor_name" label="{{ __('visitor_name') }}" required/>
                        </div>
                        <div class="w-full">
                            <x-input-full id="company_name" name="company_name" label="{{ __('company_name') }}" required/>
                        </div>
                        <div class="w-full">
                            <x-input-full id="reason" name="reason" label="{{ __('reason') }}" required/>
                        </div>
                        <div class="w-full">
                            <x-input-full id="to_see" name="to_see" label="{{ __('to_see') }}" required/>
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
