@php($toast = $toast())

@if($toast !== null)
    <div data-pajak-core-flash="{{ json_encode($toast, JSON_THROW_ON_ERROR) }}" hidden></div>
@endif
