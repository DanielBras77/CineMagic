@php
$mode = $mode ?? 'edit';
$readonly = $mode == 'show';
@endphp

<div class="flex flex-wrap space-x-8">
    <div class="grow mt-6 space-y-4">
        <x-field.input
            name="title"
            label="Title"
            :readonly="$readonly"
            :required="true"
            value="{{ old('title', $movie->title) }}" />

        <x-field.image
            name="photo_file"
            label="Photo"
            width="md"
            :readonly="$readonly"
            :required="true"
            deleteTitle="Delete Photo"
            :deleteAllow="($mode == 'edit') && ($movie->poster_filename)"
            deleteForm="form_to_delete_photo"
            :imageUrl="$movie->posterFullUrl" />

        <x-field.input
            name="year"
            label="Year"
            :readonly="$readonly"
            :required="true"
            value="{{ old('year', $movie->year) }}" />

        <x-field.select
            name="genre_code"
            label="Genre"
            :readonly="$readonly"
            value="{{ old('genre_code', $movie->genre_code) }}"
            :options='$genres'/>

        <x-field.text-area
            name="synopsis"
            label="Synopsis"
            :readonly="$readonly"
            value="{{ old('synopsis', $movie->synopsis) }}" />
        <x-field.input
            name="trailer_url"
            label="Trailer_url"
            :readonly="$readonly"
            value="{{ old('trailer_url', $movie->trailer_url) }}" />
    </div>
</div>
