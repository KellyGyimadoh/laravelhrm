@can('viewAny', 'App\\Models\\User')
    <x-layout theTitle="My Salary" href="/worker/salary">
        <div class="card">
            <div class="card-body">
                <div class="mt-3">
                    <x-forms.form action="">
                        @csrf
                        <x-forms.input name="full_name" label="Full Name" value="{{ $user->firstname.' '.$user->lastname}}" disabled />
                        <x-forms.input name="department" label="Department" value="{{ $user->department->name }}" disabled />
                        @if (!$salary)
                        <x-forms.input name="salary" label="Salary" placeholder="$50000USD" value="N/A" />
                            @else
                            <x-forms.input name="salary" label="Salary" placeholder="$50000USD" value="{{$salary->amount}}" />

                        @endif
                    </x-forms.form>
                </div>
            </div>
        </div>
    </x-layout>
@endcan

