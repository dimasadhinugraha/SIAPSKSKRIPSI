@extends('layouts.app-bootstrap')

@section('content')
<div class="container-fluid">
    @if(isset($header))
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">{{ $header }}</h1>
        </div>
    @endif
    
    {{ $slot }}
</div>
@endsection
