@php
$mode = $mode ?? 'edit';
$readonly = $mode == 'show';
@endphp

<div>
    <div>
        <x-field.input name="name" label="Name" :readonly="$readonly" value="{{ old('name', $user->name) }}" />
        <x-field.input name="email" label="Email" width="md" :readonly="$readonly" value="{{ old('email', $user->email) }}" />
        <x-field.radio-group name="type" label="Type" :readonly="$readonly"
                    value="{{ old('type', $user->type??'A') }}"
                    :options="[
                            'A' => 'Admin',
                            'E' => 'Employee',
                        ]" />


    </div>


@if ($mode=='create')

<x-field.input name="password" label="Password" :readonly="false" />
<x-field.input name="password_confirmation" label="Password Confirmation" :readonly="false"/>

@endif
