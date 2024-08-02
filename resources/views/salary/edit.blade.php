@can('viewAny', 'App\\Models\\User')

    <x-layout theTitle="Make Changes To Salary" href="/salary/{{$salary->id}}">
        <div class="card">
            <div class="card-body">
                <div class="mt-3">
                    <x-forms.form method="POST" action="/salary/{{$salary->id}}">
                        @method('PATCH')
                        <x-forms.input name="id" label="Salary ID" value="{{ $salary->id }}" disabled />
                            <x-forms.input name="full_name" label="Full Name" value="{{ $user->firstname . ' ' . $user->lastname }}"
                                disabled />
                            <x-forms.input name="department" label="Department" value="{{ $user->department->name }}"
                                disabled />

                        <x-forms.input name="amount" label="Salary" placeholder="$50000USD" value="{{$salary->amount}}" />


                        <x-forms.input type="date" name="effective_date" label="Effective Payment Date"  value="{{$salary->effective_date}}"/>

                        <x-forms.button class="btn btn-sm btn-primary">
                            Submit
                        </x-forms.button>
                    </x-forms.form>
                </div>
            </div>
        </div>
    </x-layout>
@endcan

