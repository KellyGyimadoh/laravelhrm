@can('viewAny', 'App\\Models\\User')

    <x-layout theTitle="Create New Salary" href="/salary/create">
        <div class="card">
            <div class="card-body">
                <div class="mt-3">
                    <x-forms.form method="POST" action="/salary">
                        @csrf
                        <x-forms.field label="Worker Full Name" name="">
                        <x-forms.select name='user_id'>
                            @foreach ($users as $user )
                                <option value="{{$user->id}}">{{$user->firstname}}</option>
                            @endforeach
                        </x-forms.select>
                        </x-forms.field>

                        <x-forms.input name="amount" label="Salary" placeholder="$50000USD" />


                        <x-forms.input type="date" name="effective_date" label="Effective Payment Date"/>

                        <x-forms.button class="btn btn-sm btn-primary">
                            Submit
                        </x-forms.button>
                    </x-forms.form>
                </div>
            </div>
        </div>
    </x-layout>
@endcan

