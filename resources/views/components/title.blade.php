@props([
    'title'
])

<h1 {{ $attributes->merge([ 'class' => 'text-gray-700 text-xl' ]) }}>
    {{ $slot->__toString() ? $slot->__toString() : $title }}
</h1>
