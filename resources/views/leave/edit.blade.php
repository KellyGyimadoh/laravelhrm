@can('viewAny', 'App\\Models\\User')
    <x-layout theTitle="Request Leave" href="/leave/{{ $leave->id }}">
        <div class="card">
            <div class="card-body">
                <div class="mt-3">
                    <x-forms.form method="POST" action="/leave/{{ $leave->id }}">
                        @method('PATCH')
                        @csrf
                        <x-forms.input name="id" label="Leave ID" value="{{ $leave->id }}" disabled />
                        <x-forms.input name="full_name" label="Full Name" value="{{ $user->firstname.' '.$user->lastname}}" disabled />
                        <x-forms.input name="department" label="Department" value="{{ $user->department->name }}" disabled />
                        <x-forms.input name="type" label="Leave Type" placeholder="Eg..sick..vacation" value="{{ $leave->type }}" />
                        <x-forms.input type="date" name="start_date" label="Start Date" value="{{ $leave->start_date }}" />
                        <x-forms.input type="date" name="end_date" label="End Date" value="{{ $leave->end_date }}" />

                        @switch($leave->status)
                            @case(1)
                            <x-forms.input name="status_display" label="Status"    value="Pending" disabled />
                                @break
                        @case(2)
                        <x-forms.input name="status_display" label="Status"    value="Approved" disabled />
                        @break
                        @case(3)
                        <x-forms.input name="status_display" label="Status"    value="Pending" disabled />
                        @break
                            @default
                            <x-forms.input name="status_display" label="Status"    value="N/A" disabled />
                        @endswitch
                            @can('view','App\\Models\User')
                            <x-forms.select name="status">
                                <option value="1" {{ $leave->status == 1 ? 'selected' : '' }}>Pending</option>
                                <option value="2" {{ $leave->status == 2 ? 'selected' : '' }}>Approve</option>
                                <option value="3" {{ $leave->status == 3 ? 'selected' : '' }}>Reject</option>
                            </x-forms.select>
                            @endcan

                        <x-forms.button class="btn btn-sm btn-primary">
                            Submit
                        </x-forms.button>
                    </x-forms.form>
                </div>
            </div>
        </div>
    </x-layout>
@endcan

