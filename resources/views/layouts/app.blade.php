<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>

<body class="font-sans antialiased">
    <x-banner />

    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        @livewire('navigation-menu')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main class="md:mx-4 md:my-2">
            {{ $slot }}
        </main>
    </div>

    @stack('modals')

    @livewireScripts

    @vite(['resources/js/sweetalert.js'])

    <script>
        function confirmDelete(formId) {
            Swal.fire({
                title: "¿Estas seguro?",
                text: "!No podrás revertir esta acción!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#b91c1c",
                cancelButtonColor: "#4338ca",
                cancelButtonText: "Cancelar",
                confirmButtonText: "Si, eliminar!",
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Seleccionar todos los inputs de texto y textareas
            const inputs = document.querySelectorAll('input[type="text"], textarea');

            inputs.forEach(input => {
                // Agregar evento de entrada para convertir el texto a mayúsculas
                input.addEventListener('input', function() {
                    this.value = this.value.toUpperCase();
                });
            });
        });

        // Para que funcione el sweetalert asegurarse de que Swal esté definido antes de usarlo con 
        // document.addEventListener('DOMContentLoaded', function () { aqui van los ejemplos de Sweetalert2 });
        // document.addEventListener('DOMContentLoaded', function () {
        //     Swal.fire({
        //         title: 'Error!',
        //         text: 'Do you want to continue',
        //         icon: 'error',
        //         confirmButtonText: 'Cool'
        //     });
        // });
    </script>

    @if (session('swal'))
        <script>
            window.sweetalertConfig = {!! session('swal') !!};
        </script>
    @endif

    @if (session('toast'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const toastData = {!! session('toast') !!};
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                Toast.fire(toastData);
            });
        </script>
    @endif
</body>

</html>
