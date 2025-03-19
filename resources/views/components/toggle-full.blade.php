@props(['size' => 'default', 'onColor' => 'green', 'offColor' => 'red', 'label' => null])

@php
    $baseClasses = 'relative rounded-full peer focus:outline-none transition-all';
    $sizeClasses = match ($size) {
        'small' => 'w-9 h-5 after:h-4 after:w-4 after:top-[2px] after:start-[2px]',
        'large' => 'w-14 h-7 after:h-6 after:w-6 after:top-0.5 after:start-[4px]',
        'default' => 'w-11 h-6 after:h-5 after:w-5 after:top-0.5 after:start-[2px]',
    };

    // Clases para el color activado (onColor)
    $onColorClasses = match ($onColor) {
        'green' => 'peer-checked:bg-green-600 dark:peer-checked:bg-green-600 peer-focus:ring-green-300 dark:peer-focus:ring-green-800',
        'red' => 'peer-checked:bg-red-600 dark:peer-checked:bg-red-600 peer-focus:ring-red-300 dark:peer-focus:ring-red-800',
        'blue' => 'peer-checked:bg-blue-600 dark:peer-checked:bg-blue-600 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800',
        'yellow' => 'peer-checked:bg-yellow-400 dark:peer-checked:bg-yellow-400 peer-focus:ring-yellow-300 dark:peer-focus:ring-yellow-800',
        'purple' => 'peer-checked:bg-purple-600 dark:peer-checked:bg-purple-600 peer-focus:ring-purple-300 dark:peer-focus:ring-purple-800',
        'gray' => 'peer-checked:bg-gray-600 dark:peer-checked:bg-gray-600 peer-focus:ring-gray-300 dark:peer-focus:ring-gray-700',
        default => 'peer-checked:bg-green-600 dark:peer-checked:bg-green-600 peer-focus:ring-green-300 dark:peer-focus:ring-green-800',
    };

    // Clases para el color desactivado (offColor)
    $offColorClasses = match ($offColor) {
        'green' => 'bg-green-600 dark:bg-green-700',
        'red' => 'bg-red-600 dark:bg-red-700',
        'blue' => 'bg-blue-600 dark:bg-blue-700',
        'yellow' => 'bg-yellow-600 dark:bg-yellow-700',
        'purple' => 'bg-purple-600 dark:bg-purple-700',
        'gray' => 'bg-gray-600 dark:bg-gray-700',
        default => 'bg-red-600 dark:bg-red-700',
    };
@endphp

<label class="inline-flex items-center cursor-pointer">
    <input type="checkbox" {{ $attributes->merge(['class' => 'sr-only peer']) }}>
    <div class="{{ "$baseClasses $sizeClasses $onColorClasses $offColorClasses" }}
        peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full
        peer-checked:after:border-white dark:border-gray-600
        after:content-[''] after:absolute after:bg-white after:border-gray-300 after:border after:rounded-full">
    </div>
    @if ($label)
        <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $label }}</span>
    @endif
</label>