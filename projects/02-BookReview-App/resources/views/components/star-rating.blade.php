@if ($rating)
    @for ($i = 1; $i <= 5; $i++)
        {{ $i <= round($rating) ? '*' : '_' }}
    @endfor
@else
    No rating yet
@endif
