<div {{ $attributes }}>
    <form method="GET" action="{{ $filterAction }}">
        <div class="flex justify-between space-x-3">
            <div class="grow flex flex-row space-y-2">
                <x-field.select name="genre" label="Genre" value="{{ $genre }}" :options="$genres" width="1/3" />
                <x-field.input name="title" label="Title" class="grow" value="{{ $title }}" width="1/3" />
                <x-field.input name="year" label="Year" class="grow" value="{{ $year }}" width="1/3" />
            </div>
            <div class="grow-0 flex flex-col space-y-3 justify-start">
                <div class="pt-6">
                    <x-button element="submit" type="dark" text="Filter" />
                </div>
                <div>
                    <x-button element="a" type="light" text="Cancel" :href="$resetUrl" />
                </div>
            </div>
        </div>
    </form>
</div>
