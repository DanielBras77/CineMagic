@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp
<x-field.input name="email" label="Email" width="md"
                :readonly="$readonly || ($mode == 'edit')"
                value="{{ old('email', $customer->user->email) }}"/>

<x-field.input name="name" label="Name" :readonly="$readonly"
                value="{{ old('name', $customer->user->name) }}"/>