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
                            <x-select-full name="status_id" id="status_id" label="{{ __('Status') }}"
                                defaultValue="{{ $user->status_id }}" required>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status->id }}" @selected(old('status_id', $user->status_id) == $status->id)>
                                        {{ $status->name }}
                                    </option>
                                @endforeach
                            </x-select-full>
                        </div>
                        <div class="w-full">
                            <x-select-full name="company_id" id="company_id" label="{{ __('Company') }}"
                                defaultValue="{{ $user->company_id }}">
                                @foreach ($companies as $company)
                                    <option value="{{ $company->id }}" @selected(old('company_id', $user->company_id) == $company->id)>
                                        {{ $company->name }}
                                    </option>
                                @endforeach
                            </x-select-full>
                        </div>
                        <div class="w-full">
                            <x-select-full name="headquarter_id" id="headquarter_id" label="{{ __('Headquarter') }}"
                                defaultValue="{{ $user->headquarter_id }}" required>
                                @foreach ($headquarters as $headquarter)
                                    <option value="{{ $headquarter->id }}" @selected(old('headquarter_id', $user->headquarter_id) == $headquarter->id)>
                                        {{ $headquarter->company->name }} - {{ $headquarter->name }}
                                    </option>
                                @endforeach
                            </x-select-full>
                        </div> 
                    </div>

                    <div class="space-y-4 sm:flex sm:space-x-4 sm:space-y-0">
                        <div class="w-full">
                            <x-input-full id="email" name="email" label="{{ __('Email') }}"
                                defaultValue="{{ $user->email }}" />
                        </div>
                        <div class="w-full">
                            <x-input-full id="name" name="name" label="{{ __('Nombre(s)') }}"
                                defaultValue="{{ $user->name }}" />
                        </div>
                        <div class="w-full">
                            <x-input-full id="password" name="password" label="{{ __('Password') }}"
                                type="password" />
                        </div>
                    </div>

                    <div class="space-y-4 sm:flex sm:space-x-4 sm:space-y-0">
                        <div class="w-full">
                            @if ($roles->count())
                                <h3 class="text-sm font-medium text-gray-700 pt-5">{{ __('Roles asociados') }}</h3>
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 py-6 px-2">
                                    @foreach ($roles as $role)
                                        <div>
                                            <label for="role_{{ $role->id }}" class="inline-flex items-center">
                                                <input type="checkbox" id="role_{{ $role->id }}" name="roles[]"
                                                    value="{{ $role->id }}" class="form-checkbox"
                                                    {{ $user->roles->contains($role->id) ? 'checked' : '' }}>
                                                <span class="ml-2">{{ $role->name }}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </x-form-full>

</x-app-layout>
