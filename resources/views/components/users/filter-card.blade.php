<div {{ $attributes }}>
    <form method="GET" action="{{ $filterAction }}">
        <div class="flex justify-between space-x-3">
            <div class="grow flex flex-row space-y-2">

                    <x-field.input class="mt-2"  name="name" label="Name" value="{{ $name }}" width="1/3" />


                    <x-field.input name="email" label="Email" class="grow" value="{{ $email }}" width="1/3" />

                    <x-field.select name="type" label="Type" class="grow" :options="[null=>'All Types', 'A'=>'Admin', 'E'=>'Employee']" value="{{ $type }}" width="1/3" />

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
