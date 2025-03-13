@php
    $id = $id ?? $name;
    $required = $required ?? false;
    $placeholder = $placeholder ?? null;
    $defaultValue = $defaultValue ?? null;
    $errorClass = $errors->has($name) ? 'border-red-500 dark:border-red-500' : '';
    $defaultClass = "block mt-1 w-full bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-indigo-600 focus:border-indigo-600 dark:bg-gray-900 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-600 dark:focus:border-indigo-600 $errorClass";
@endphp

<div class="py-2 w-full">
    @if($label)
        <x-label for="{{ $id }}" :value="$label" />
    @endif
    <textarea id="{{ $id }}" class="{{ $defaultClass }}" name="{{ $name }}" rows="4" @if($required) required @endif @if($placeholder) placeholder="{{ $placeholder }}" @endif>{{ old($name, $defaultValue) }}</textarea>
</div>