@php
    $logoUrl = asset('images/ciasmara.png');
@endphp

<div style="text-align:center; padding:12px 0;">
    @if (! empty($url))
        <a href="{{ $url }}" style="display:inline-block;">
            <img src="{{ $logoUrl }}" alt="Ciasmara" style="width:120px; max-width:40%; height:auto; display:block; margin:0 auto; border:0;">
        </a>
    @else
        <img src="{{ $logoUrl }}" alt="Ciasmara" style="width:120px; max-width:40%; height:auto; display:block; margin:0 auto; border:0;">
    @endif
</div>
