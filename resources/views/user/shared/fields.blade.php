@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp

<div class="flex flex-wrap space-x-8">
    <div class="grow mt-6 space-y-4">
        <x-field.input name="name" label="Name" :readonly="$readonly"
                        value="{{ old('name', $user->name) }}"/>
        <x-field.input name="nif" type="nif" label="nif" :readonly="$readonly"
                        value="{{ old('nif', $user->customer->nif) }}"/>
        <div class="flex space-x-4">
            <x-field.input name="payment_type" label="payment_type" :readonly="$readonly"
                        value="{{ old('payment_type', $user->customer->payment_type) }}"/>
            <x-field.input name="payment_ref" label="payment_ref" :readonly="$readonly"
                        value="{{ old('payment_ref', $user->customer->payment_ref) }}"/>
        </div>
    </div>
    <div class="pb-6">
        <x-field.image
            name="photo_file"
            label="Photo"
            width="md"
            :readonly="$readonly"
            deleteTitle="Delete Photo"
            :deleteAllow="($mode == 'edit') && ($teacher->user->photo_url)"
            deleteForm="form_to_delete_photo"
            :imageUrl="$user->photo_filename"/>
    </div>
</div>
