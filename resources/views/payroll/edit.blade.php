@can('viewAny', 'App\\Models\\User')
    <x-layout theTitle="Update Payroll" href="/payroll/{{ $payroll->id }}">
        <div class="card">
            <div class="card-body">
                <div class="mt-3">
                    <a href="/payrolls"><button class="btn btn-sm btn-primary" type="submit" title="Search">Back To All Payroll Records</button></a>
                </div>
                <div class="mt-3">
                    <x-forms.form method="POST" action="/payroll/{{ $payroll->id }}">
                        @method('PATCH')
                        @csrf
                        <x-forms.input name="id" label="Payroll ID" value="{{ $payroll->id }}" disabled />
                        <x-forms.input name="full_name" label="Full Name" value="{{ $user->firstname . ' ' . $user->lastname }}"
                            disabled />
                        <x-forms.input name="department" label="Department" value="{{ $user->department->name }}"
                            disabled />
                        <x-forms.input name="salary" label="Salary" placeholder="$50000USD"
                            value="{{ $payroll->salary }}" />
                        <x-forms.input type="date" name="paydate" label="Payment Date" value="{{ $payroll->paydate }}" />

                        @switch($payroll->status)
                            @case(1)
                                <x-forms.input name="status_display" label="Status" value="Unpaid" disabled />
                            @break

                            @case(2)
                                <x-forms.input name="status_display" label="Status" value="Paid" disabled />
                            @break

                            @case(3)
                                <x-forms.input name="status_display" label="Status" value="Pending" disabled />
                            @break

                            @default
                                <x-forms.input name="status_display" label="Status" value="N/A" disabled />
                        @endswitch
                        @can('view', 'App\\Models\User')
                            <x-forms.select name="status">
                                <option value="1" {{ $payroll->status == 1 ? 'selected' : '' }}>Unpaid</option>
                                <option value="2" {{ $payroll->status == 2 ? 'selected' : '' }}>Paid</option>
                                <option value="3" {{ $payroll->status == 3 ? 'selected' : '' }}>Pending</option>
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
