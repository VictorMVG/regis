<x-app-layout>

    <x-form-full title="{{ __('Creating:') }} {{ __('New visit') }}" method="POST" action="{{ route('binnacles.store') }}"
        buttonText="{{ __('Save') }}" maxWidthClass="max-w-7xl" enctype="multipart/form-data">

        <div class="py-4 border-gray-200 sm:py-5 dark:border-gray-700">
            <!-- Inputs -->
            <div class="grid gap-4 md:gap-6 md:grid-cols-1">
                <!-- Column -->
                <div class="space-y-2 sm:space-y-4">

                    <div class="space-y-4 sm:flex sm:space-x-4 sm:space-y-0">
                        @if (auth()->user()->hasRole('SUPER USUARIO|ADMINISTRADOR GENERAL|ADMINISTRADOR DE SEDE'))
                            <div class="w-full">
                                <x-select-full name="headquarter_id" id="headquarter_id" label="{{ __('Headquarter') }}"
                                    defaultOption="Selecciona una sede">
                                    @foreach ($headquarters as $headquarter)
                                        <option value="{{ $headquarter->id }}" @selected(old('headquarter_id') == $headquarter->id)>
                                            {{ $headquarter->company->name }} - {{ $headquarter->name }}
                                        </option>
                                    @endforeach
                                </x-select-full>
                            </div>
                        @endif
                        <div class="w-full">
                            <x-select-full name="observation_type_id" id="observation_type_id"
                                label="{{ __('Observation type') }}" defaultOption="Selecciona un tipo">
                                @foreach ($observationTypes as $observationType)
                                    <option value="{{ $observationType->id }}" @selected(old('observation_type_id') == $observationType->id)>
                                        {{ $observationType->name }}
                                    </option>
                                @endforeach
                            </x-select-full>
                        </div>
                    </div>

                    <div x-data="{ image: false }">
                        <div class="space-y-4 sm:flex sm:space-x-4 sm:space-y-0">
                            
                            <div class="w-full">
                                <x-input-full id="title" name="title" label="{{ __('Title observation') }}"
                                    required />
                            </div>

                            <div class="w-1/2 pt-7 pl-7">
                                <input type="hidden" name="image" :value="unit ? 1 : 0">
                                <x-toggle-full id="image" name="image" label="{{ __('Images') }}" size="large"
                                    onColor="green" offColor="gray" x-model="image" />
                                <p class="text-sm font-medium">
                                    <span
                                        :class="image
                                            ?
                                            'bg-green-300 text-green-800 text-xs font-extrabold me-2 px-2.5 py-0.5 rounded-lg dark:bg-green-900 dark:text-green-300' :
                                            'bg-gray-300 text-gray-800 text-xs font-extrabold me-2 px-2.5 py-0.5 rounded-lg dark:bg-gray-700 dark:text-gray-300'"
                                        x-text="image ? '{{ __('CON IMÁGENES') }}' : '{{ __('SIN IMÁGENES') }}'">
                                    </span>
                                </p>
                            </div>
                            <!-- Bloque que depende del toggle "image" -->
                            <div x-show="image" x-cloak class="pt-5">
                                <div class="w-full">
                                    <label for="images">{{ __('Images') }}</label>
                                    <input type="file" name="images[]" id="images" x-bind:required="image"
                                        multiple>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4 sm:flex sm:space-x-4 sm:space-y-0">
                        <div class="w-full">
                            <x-textarea-full id="observation" name="observation" label="{{ __('Observation') }}" />
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </x-form-full>

</x-app-layout>
