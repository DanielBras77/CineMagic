@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp
<x-field.input name="abbreviation" label="Abbreviation" width="md"
                :readonly="$readonly || ($mode == 'edit')"
                value="{{ old('abbreviation', $department->abbreviation) }}"/>
<x-field.input name="name" label="Name" :readonly="$readonly"
                value="{{ old('name', $department->name) }}"/>
<x-field.input name="name_pt" label="Name (Portuguese)" :readonly="$readonly"
               value="{{ old('name_pt', $department->name_pt) }}"/>
