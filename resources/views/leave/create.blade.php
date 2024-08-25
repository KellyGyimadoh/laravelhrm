@can('viewAny', 'App\\Models\User')
    <x-layout theTitle="Request Leave" href="/leave/request">
        <div class="card">
            <div class="card-body">
                <div class="mt-3">

                    <x-forms.form method="POST" action="/leave/request" id="leaveform">
                        <x-forms.input name="id" label="ID" value="{{ $worker->id }}" disabled />
                        <x-forms.input name="" label="FullName"
                            value="{{ $worker->firstname . '' . $worker->lastname }}" disabled />
                        <x-forms.input name="" label="Department" value="{{ $worker->department->name }}" disabled />
                        <x-forms.input name="type" label="Leave Type" placeholder="Eg..sick..vacation" />
                        <x-forms.input type="date" name="start_date" label="Start Date" />
                        <x-forms.input type="date" name="end_date" label="End Date" />
                        <x-forms.button class="btn btn-sm btn-primary">
                            Request Leave
                        </x-forms.button>
                    </x-forms.form>
                </div>

            </div>
        </div>


    </x-layout>
@endcan
