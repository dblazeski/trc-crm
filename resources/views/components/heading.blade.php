@props([
    'left',
    'right' => null,
])

<div {{ $attributes->merge([ 'class' => 'flex justify-between text-gray-700 text-xl' ]) }}>

    <div {{ $left->attributes }}>
        <h1>
            {{ $left }}
        </h1>
    </div>

    @if($right)
        <div {{ $right->attributes }}>
            {{ $right }}
        </div>
    @endif

</div>

