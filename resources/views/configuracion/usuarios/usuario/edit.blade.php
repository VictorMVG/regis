<x-app-layout>

    <x-form-full title="{{ __('Editing:') }} {{ $user->name }}" method="PUT"
        action="{{ route('users.update', $user) }}" buttonText="{{ __('Update') }}" enctype="multipart/form-data"
        maxWidthClass="max-w-7xl">

        <div class="py-4 border-gray-200 sm:py-5 dark:border-gray-700">
            <!-- Inputs -->
            <div class="grid gap-4 md:gap-6 md:grid-cols-1">
                <!-- Column -->
                <div class="space-y-2 sm:space-y-4">
                    <div class="space-y-4 sm:flex sm:space-x-4 sm:space-y-0">
                        <div class="w-full">
                            <x-input-full id="email" name="email" label="{{ __('Email') }}"
                                defaultValue="{{ $user->email }}" />
                        </div>
                        <div class="w-full">
                            <x-input-full id="password" name="password" label="{{ __('Password') }}" type="password" />
                        </div>
                        <div class="w-1/2">
                            <x-input-full id="employee_number" name="employee_number"
                                label="{{ __('Número de empleado') }}"
                                defaultValue="{{ $user->userDetail->employee_number }}" type="number" />
                        </div>
                        <div class="w-full">
                            <x-select-full name="user_category_id" id="user_category_id"
                                label="{{ __('Categoria del usuario') }}"
                                defaultValue="{{ $user->userDetail->user_category_id }}">
                                @foreach ($userCategories as $userCategory)
                                    <option value="{{ $userCategory->id }}" @selected(old('user_category_id', $user->userDetail->user_category_id) == $userCategory->id)>
                                        {{ $userCategory->name }}</option>
                                @endforeach
                            </x-select-full>
                        </div>
                    </div>

                    <div class="space-y-4 sm:flex sm:space-x-4 sm:space-y-0">
                        <div class="w-3/4">
                            <x-select-full name="honorary_title_id" id="honorary_title_id"
                                label="{{ __('Título honorifico') }}"
                                defaultValue="{{ $user->userDetail->honorary_title_id }}">
                                @foreach ($honoraryTitles as $honoraryTitle)
                                    <option value="{{ $honoraryTitle->id }}" @selected(old('honorary_title_id', $user->userDetail->honorary_title_id) == $honoraryTitle->id)>
                                        {{ $honoraryTitle->name }}</option>
                                @endforeach
                            </x-select-full>
                        </div>
                        <div class="w-full">
                            <x-input-full id="name" name="name" label="{{ __('Nombre(s)') }}"
                                defaultValue="{{ $user->userDetail->name }}" />
                        </div>
                        <div class="w-full">
                            <x-input-full id="paternal_surname" name="paternal_surname"
                                label="{{ __('Apellido paterno') }}"
                                defaultValue="{{ $user->userDetail->paternal_surname }}" />
                        </div>
                        <div class="w-full">
                            <x-input-full id="maternal_surname" name="maternal_surname"
                                label="{{ __('Apellido materno') }}"
                                defaultValue="{{ $user->userDetail->maternal_surname }}" />
                        </div>
                    </div>

                    <div class="space-y-4 sm:flex sm:space-x-4 sm:space-y-0">
                        <div class="w-full">
                            <x-input-full id="curp" name="curp" label="{{ __('CURP') }}"
                                defaultValue="{{ $user->userDetail->curp }}" />
                        </div>
                        <div class="w-full">
                            <x-input-full id="rfc" name="rfc" label="{{ __('RFC') }}"
                                defaultValue="{{ $user->userDetail->rfc }}" />
                        </div>
                        <div class="w-full">
                            <x-input-full id="nss" name="nss" label="{{ __('NSS') }}"
                                defaultValue="{{ $user->userDetail->nss }}" />
                        </div>
                        <div class="w-full">
                            <x-select-full name="blood_type_id" id="blood_type_id" label="{{ __('Tipo sanguíneo') }}"
                                defaultValue="{{ $user->userDetail->blood_type_id }}">
                                @foreach ($bloodTypes as $bloodType)
                                    <option value="{{ $bloodType->id }}" @selected(old('blood_type_id', $user->userDetail->blood_type_id) == $bloodType->id)>
                                        {{ $bloodType->name }}</option>
                                @endforeach
                            </x-select-full>
                        </div>
                    </div>

                    <div class="space-y-4 sm:flex sm:space-x-4 sm:space-y-0">
                        <div class="w-full">
                            <x-input-full id="phone_number" name="phone_number" label="{{ __('Número de teléfono') }}"
                                defaultValue="{{ $user->userDetail->phone_number }}" type="number" />
                        </div>
                        <div class="w-full">
                            <x-input-full id="allergies" name="allergies" label="{{ __('Alergias?') }}"
                                defaultValue="{{ $user->userDetail->allergies }}" />
                        </div>
                        <div class="w-full">
                            <x-input-full id="emergency_contact_name" name="emergency_contact_name"
                                label="{{ __('Contacto de emergencia') }}"
                                defaultValue="{{ $user->userDetail->emergency_contact_name }}" />
                        </div>
                        <div class="w-full">
                            <x-input-full id="emergency_contact_phone" name="emergency_contact_phone"
                                label="{{ __('Número del contacto') }}"
                                defaultValue="{{ $user->userDetail->emergency_contact_phone }}" type="number" />
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </x-form-full>

</x-app-layout>
