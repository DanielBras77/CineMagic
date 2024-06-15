@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp
<x-field.input name="email" label="Email" width="md"
                :readonly="$readonly || ($mode == 'edit')"
                value="{{ old('email', $customer->email) }}"/>

<x-field.input name="name" label="Name" :readonly="$readonly"
                value="{{ old('name', $customer->name) }}"/>

<x-field.image
        name="photo_file"
        label="Photo"
        width="md"
        deleteTitle="Delete Photo"
        :deleteAllow="($mode == 'edit') && ($teacher->user->photo_url)"
        deleteForm="form_to_delete_photo"
        :imageUrl="$customer->photoFullUrl"/>
