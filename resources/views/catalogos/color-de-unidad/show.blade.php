<x-app-layout>
    <div class="bg-white dark:bg-gray-800 relative shadow-md rounded-lg overflow-hidden">
        <div class="grid grid-cols-4 grid-rows-8 gap-4 p-5">
            <!-- Título -->
            <div class="col-span-2">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">
                    {{ __('Detalles del Curso') }}
                </h2>
            </div>

            <!-- Botones -->
            <div class="col-span-2 col-start-3 flex justify-end">
                <a href="{{ route('courses.edit', $course) }}">
                    <x-button type="button" color="green">
                        <svg class="h-5 w-5 mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 7.8v8.4M7.8 12h8.4m4.8 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        {{ __('Edit') }}
                    </x-button>
                </a>
            </div>

            <!-- Avatar y Nombre -->
            <div class="col-span-4 row-start-2 flex items-center">
                <div class="flex space-x-4">
                    <img class="h-16 w-16 rounded-lg"
                        src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/helene-engels.png"
                        alt="User avatar" />
                    <div>
                        <span
                            class="mb-2 inline-block bg-primary-100 text-normal text-primary-800 dark:bg-primary-900 dark:text-primary-300 bg-indigo-100 text-indigo-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-lg dark:bg-indigo-900 dark:text-indigo-300">
                            NO. DE EMPLEADO: {{ $course->userDetail->employee_number ?? '-' }}
                        </span>
                        <h2
                            class="flex items-center text-xl font-bold leading-none text-gray-900 dark:text-white sm:text-2xl">
                            {{ $course->name ?? '-' }}
                        </h2>
                    </div>
                </div>
            </div>

            <!-- Información del Usuario -->
            <div class="col-span-2 row-start-3">
                <dl>
                    <dt class="font-semibold text-gray-900 dark:text-white">{{ __('Email') }}</dt>
                    <dd class="text-gray-500 dark:text-gray-400">{{ $course->email ?? '-' }}</dd>
                </dl>
            </div>
            <div class="col-span-2 col-start-3 row-start-3">
                <dl>
                    <dt class="font-semibold text-gray-900 dark:text-white">{{ __('Número telefonico') }}</dt>
                    <dd class="text-gray-500 dark:text-gray-400">{{ $course->userDetail->phone_number ?? '-' }}</dd>
                </dl>
            </div>
            <div class="col-span-2 row-start-4">
                <dl>
                    <dt class="font-semibold text-gray-900 dark:text-white">{{ __('Número de seguridad social') }}</dt>
                    <dd class="text-gray-500 dark:text-gray-400">{{ $course->userDetail->nss ?? '-' }}</dd>
                </dl>
            </div>
            <div class="col-span-2 col-start-3 row-start-4">
                <dl>
                    <dt class="font-semibold text-gray-900 dark:text-white">{{ __('RFC') }}</dt>
                    <dd class="text-gray-500 dark:text-gray-400">{{ $course->userDetail->rfc ?? '-' }}</dd>
                </dl>
            </div>
            <div class="col-span-2 row-start-5">
                <dl>
                    <dt class="font-semibold text-gray-900 dark:text-white">CURP</dt>
                    <dd class="text-gray-500 dark:text-gray-400">{{ $course->userDetail->curp ?? '-' }}</dd>
                </dl>
            </div>
            <div class="col-span-2 col-start-3 row-start-5">
                <dl>
                    <dt class="font-semibold text-gray-900 dark:text-white">Tipo de Sangre</dt>
                    <dd class="text-gray-500 dark:text-gray-400">{{ $course->userDetail->bloodType->name ?? '-' }}</dd>
                </dl>
            </div>
            <div class="col-span-2 row-start-6">
                <dl>
                    <dt class="font-semibold text-gray-900 dark:text-white">Título Honorífico</dt>
                    <dd class="text-gray-500 dark:text-gray-400">
                        {{ $course->userDetail->honoraryTitle->name . ' - ' . $course->userDetail->honoraryTitle->alias ?? '-' }}
                    </dd>
                </dl>
            </div>
            <div class="col-span-2 col-start-3 row-start-6">
                <dl>
                    <dt class="font-semibold text-gray-900 dark:text-white">Nombre completo</dt>
                    <dd class="text-gray-500 dark:text-gray-400">{{ $course->userDetail->name ?? '-' }}
                        {{ $course->userDetail->paternal_surname ?? '-' }}
                        {{ $course->userDetail->maternal_surname ?? '-' }}
                    </dd>
                </dl>
            </div>
            <div class="col-span-2 row-start-7">
                <dl>
                    <dt class="font-semibold text-gray-900 dark:text-white">Categoría de Usuario</dt>
                    <dd class="text-gray-500 dark:text-gray-400">{{ $course->userDetail->userCategory->name ?? '-' }}
                    </dd>
                </dl>
            </div>
            <div class="col-span-2 col-start-3 row-start-7">
                <dl>
                    <dt class="font-semibold text-gray-900 dark:text-white">Alergias</dt>
                    <dd class="text-gray-500 dark:text-gray-400">{{ $course->userDetail->allergies ?? '-' }}</dd>
                </dl>
            </div>
            <div class="col-span-2 row-start-8">
                <dl>
                    <dt class="font-semibold text-gray-900 dark:text-white">Nombre de Contacto de Emergencia</dt>
                    <dd class="text-gray-500 dark:text-gray-400">{{ $course->userDetail->emergency_contact_name ?? '-' }}
                    </dd>
                </dl>
            </div>
            <div class="col-span-2 col-start-3 row-start-8">
                <dl>
                    <dt class="font-semibold text-gray-900 dark:text-white">Teléfono de Contacto de Emergencia</dt>
                    <dd class="text-gray-500 dark:text-gray-400">
                        {{ $course->userDetail->emergency_contact_phone ?? '-' }}
                    </dd>
                </dl>
            </div>
        </div>
    </div>

</x-app-layout>
