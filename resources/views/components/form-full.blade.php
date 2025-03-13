@php
    $title = $title ?? null;
    $method = $method ?? 'POST';
    $action = $action ?? '#';
    $enctype = $enctype ?? null;
    $buttonText = $buttonText ?? __('Save');
    $maxWidthClass = $maxWidthClass ?? 'max-w-2xl';
@endphp

<div class="flex items-center justify-center p-5 bg-white dark:bg-gray-800 relative rounded-lg overflow-hidden">
    <div class="w-full {{ $maxWidthClass }}">
        @if($title)
            <div class="text-center text-xl font-bold text-gray-600 dark:text-gray-300">
                {{ $title }}
            </div>
        @endif
        <form method="{{ $method === 'GET' ? 'GET' : 'POST' }}" action="{{ $action }}" enctype="{{ $enctype }}">
            @csrf
            @if($method === 'PUT' || $method === 'PATCH')
                @method($method)
            @endif
            <x-validation-errors class="block mt-1 w-full" />
            {{ $slot }}
            <div class="flex items-center justify-end mt-4">
                <x-button class="ms-4" onclick="if (this.form.checkValidity()) { this.disabled = true; this.form.submit(); }">
                    {{ $buttonText }}
                </x-button>
            </div>
        </form>
    </div>
</div>