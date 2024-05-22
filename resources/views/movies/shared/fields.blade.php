@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp
<x-field.text-area name="synopsis" label="Synopsis"
                :readonly="$readonly"
                value="{{ old('synopsis', $movie->synopsis) }}"/>
<x-field.input name="trailer_url" label="Trailer_url" :readonly="$readonly"
                value="{{ old('trailer_url', $movie->trailer_url) }}"/>
