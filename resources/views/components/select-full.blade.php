@php
    $width = $width ?? 'w-full';
    $label = $label ?? null;
    $defaultOption = $defaultOption ?? __('Selecciona una opción');
    $color = $color ?? 'indigo';
    $defaultClass = "bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-$color-600 focus:border-$color-600 block w-full p-2.5 dark:bg-gray-900 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-$color-600 dark:focus:border-$color-600";
    $errorClass = $errors->has($name) ? 'border-red-500 dark:border-red-500' : '';
@endphp

<div class="py-2 {{ $width }}">
    @if($label)
        <x-label for="{{ $name }}" :value="$label" />
    @endif
    <select {{ $attributes->merge(['name' => $name, 'id' => $name, 'class' => $defaultClass . ' ' . $errorClass]) }} :value="old($name)">
        <option value="" selected disabled hidden>{{ $defaultOption }}</option>
        {{ $slot }}
    </select>
</div>