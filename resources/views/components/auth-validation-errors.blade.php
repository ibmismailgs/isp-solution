@props(['errors'])

@if ($errors->any())
    <div {{ $attributes }}>
        <div class="text-danger" style="font-size: 14px">
            {{ __('Whoops! Something went wrong.') }}
        </div>

        <ul class="text-danger" style="font-size: 14px">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
