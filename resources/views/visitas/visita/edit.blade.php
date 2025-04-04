<x-app-layout>

    <x-form-full title="{{ __('Editing:') }} {{ $visit->visitor_name }}" method="PUT"
        action="{{ route('visits.update', $visit) }}" buttonText="{{ __('Update') }}" maxWidthClass="max-w-7xl">

        <div class="py-4 border-gray-200 sm:py-5 dark:border-gray-700">
            <!-- Inputs -->
            <div class="grid gap-4 md:gap-6 md:grid-cols-1">
                <!-- Column -->
                <div class="space-y-2 sm:space-y-4">

                    <div class="space-y-4 sm:flex sm:space-x-4 sm:space-y-0">
                        @if (auth()->user()->hasRole('SUPER USUARIO|ADMINISTRADOR GENERAL|ADMINISTRADOR DE SEDE'))
                            <div class="w-full">
                                <x-select-full name="headquarter_id" id="headquarter_id" label="{{ __('Unit color') }}"
                                    defaultValue="{{ $visit->headquarter_id }}">
                                    @foreach ($headquarters as $headquarter)
                                        <option value="{{ $headquarter->id }}" @selected(old('headquarter_id', $visit->headquarter_id) == $headquarter->id)>
                                            {{ $headquarter->company->name }} - {{ $headquarter->name }}
                                        </option>
                                    @endforeach
                                </x-select-full>
                            </div>
                        @endif
                        <div class="w-full">
                            <x-input-full id="visitor_name" name="visitor_name" label="{{ __('Visitor name') }}"
                                required defaultValue="{{ old('visitor_name', $visit->visitor_name) }}" />
                        </div>
                        <div class="w-full">
                            <x-input-full id="company_name" name="company_name" label="{{ __('Company name') }}"
                                required defaultValue="{{ old('visitor_name', $visit->company_name) }}" />
                        </div>
                    </div>

                    <div class="space-y-4 sm:flex sm:space-x-4 sm:space-y-0">
                        <div class="w-full">
                            <x-input-full id="reason" name="reason" label="{{ __('Reason') }}"
                                required defaultValue="{{ old('reason', $visit->reason) }}" />
                        </div>
                        <div class="w-full">
                            <x-input-full id="to_see" name="to_see" label="{{ __('To see') }}"
                                required defaultValue="{{ old('to_see', $visit->to_see) }}" />
                        </div>
                    </div>

                    <div x-data="{
                        alcoholTest: {{ old('alcohol_test', $visit->alcohol_test) ? 'true' : 'false' }},
                        unit: {{ old('unit', $visit->unit) ? 'true' : 'false' }}
                    }">
                        <div class="space-y-4 sm:flex sm:space-x-4 sm:space-y-0">
                            <div class="w-full">
                                <input type="hidden" name="alcohol_test" :value="alcoholTest ? 1 : 0">
                                <x-toggle-full id="alcohol_test" name="alcohol_test" label="{{ __('Alcohol test') }}"
                                    size="large" onColor="red" offColor="gray" x-model="alcoholTest" />
                                <p class="mt-2 text-sm font-medium">
                                    <span
                                        :class="alcoholTest
                                            ?
                                            'bg-red-300 text-red-800 text-xs font-extrabold me-2 px-2.5 py-0.5 rounded-lg dark:bg-red-900 dark:text-red-300' :
                                            'bg-gray-300 text-gray-800 text-xs font-extrabold me-2 px-2.5 py-0.5 rounded-lg dark:bg-gray-700 dark:text-gray-300'"
                                        x-text="alcoholTest ? '{{ __('POSITIVO') }}' : '{{ __('NEGATIVO') }}'">
                                    </span>
                                </p>
                            </div>
                            <div class="w-full">
                                <input type="hidden" name="unit" :value="unit ? 1 : 0">
                                <x-toggle-full id="unit" name="unit" label="{{ __('Unit') }}" size="large"
                                    onColor="green" offColor="gray" x-model="unit" />
                                <p class="mt-2 text-sm font-medium">
                                    <span
                                        :class="unit
                                            ?
                                            'bg-green-300 text-green-800 text-xs font-extrabold me-2 px-2.5 py-0.5 rounded-lg dark:bg-green-900 dark:text-green-300' :
                                            'bg-gray-300 text-gray-800 text-xs font-extrabold me-2 px-2.5 py-0.5 rounded-lg dark:bg-gray-700 dark:text-gray-300'"
                                        x-text="unit ? '{{ __('CON VEHICULO') }}' : '{{ __('SIN VEHICULO') }}'">
                                    </span>
                                </p>
                            </div>
                        </div>

                        <!-- Bloque que depende del toggle "unit" -->
                        <div x-show="unit" x-cloak class="pt-5">
                            <div class="space-y-4 sm:flex sm:space-x-4 sm:space-y-0">
                                <div class="w-full">
                                    <x-input-full id="unit_plate" name="unit_plate" label="{{ __('Unit plate') }}"
                                        defaultValue="{{ $visit->unit_plate }}" />
                                </div>
                                <div class="w-full">
                                    <x-input-full id="unit_model" name="unit_model" label="{{ __('Unit model') }}"
                                        defaultValue="{{ $visit->unit_model }}" />
                                </div>
                                <div class="w-full">
                                    <x-input-full id="unit_number" name="unit_number" label="{{ __('Unit number') }}"
                                        defaultValue="{{ $visit->unit_number }}" />
                                </div>
                            </div>
                            <div class="space-y-4 sm:flex sm:space-x-4 sm:space-y-0">
                                <div class="w-full">
                                    <x-select-full name="unit_type_id" id="unit_type_id" label="{{ __('Unit type') }}"
                                        defaultValue="{{ $visit->unit_type_id }}">
                                        @foreach ($unitTypes as $unitType)
                                            <option value="{{ $unitType->id }}" @selected(old('unit_type_id', $visit->unit_type_id) == $unitType->id)>
                                                {{ $unitType->name }}
                                            </option>
                                        @endforeach
                                    </x-select-full>
                                </div>
                                <div class="w-full">
                                    <x-select-full name="unit_color_id" id="unit_color_id"
                                        label="{{ __('Unit color') }}" defaultValue="{{ $visit->unit_color_id }}">
                                        @foreach ($unitColors as $unitColor)
                                            <option value="{{ $unitColor->id }}" @selected(old('unit_color_id', $visit->unit_color_id) == $unitColor->id)>
                                                {{ $unitColor->name }}
                                            </option>
                                        @endforeach
                                    </x-select-full>
                                </div>
                            </div>
                        </div>

                        <!-- Campos para SUPER USUARIO, ADMINISTRADOR GENERAL y ADMINISTRADOR DE SEDE -->
                        @if (auth()->user()->hasRole('SUPER USUARIO|ADMINISTRADOR GENERAL|ADMINISTRADOR DE SEDE'))
                            <div class="space-y-4 sm:flex sm:space-x-4 sm:space-y-0">
                                <div class="w-full">
                                    <x-input-full id="created_at" name="created_at" type="datetime-local"
                                        label="{{ __('Entry datetime') }}"
                                        defaultValue="{{ $visit->created_at->format('Y-m-d\TH:i') }}" />
                                </div>
                                <div class="w-full">
                                    <x-input-full id="exit_time" name="exit_time" type="datetime-local"
                                        label="{{ __('Exit datetime') }}"
                                        defaultValue="{{ $visit->exit_time ? $visit->exit_time->format('Y-m-d\TH:i') : '' }}" />
                                </div>
                            </div>
                        @endif

                        <div class="space-y-4 sm:flex sm:space-x-4 sm:space-y-0">
                            <div class="w-full">
                                <x-textarea-full id="comment" name="comment" label="{{ __('Comments') }}"
                                :defaultValue="old('comment', $visit->comment)" />
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </x-form-full>

</x-app-layout>
