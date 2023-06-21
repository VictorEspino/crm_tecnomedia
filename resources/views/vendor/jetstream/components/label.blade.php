@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-xs text-gray-700 py-1']) }}>
    {{ $value ?? $slot }}
</label>
