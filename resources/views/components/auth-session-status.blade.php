@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'text-primary']) }} style="font-size: 14px;">
        {{ $status }}
    </div>
@endif
