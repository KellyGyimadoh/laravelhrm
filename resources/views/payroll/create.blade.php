@can('viewAny', 'App\\Models\\User')

    <x-layout theTitle="Create New Payroll" href="/payroll/create">
        <div class="card">
            <div class="card-body">
                <div class="mt-3">
                    <x-forms.form method="POST" action="/payroll/store">
                        @csrf
                        <x-forms.field label="Worker Full Name" name="">
                        <x-forms.select name='userid'>
                            @foreach ($users as $user )
                                <option value="{{$user->id}}">{{$user->firstname}}</option>
                            @endforeach
                        </x-forms.select>
                        </x-forms.field>
                        <x-forms.input name="salary" label="Salary" placeholder="$50000USD" />


                        <x-forms.input type="date" name="paydate" label="Payment Date"/>
                       <x-forms.field label="Payment Status" name="">
                            <x-forms.select name="status">
                                <option value="" >Select Payment Status</option>
                                <option value="1" >Unpaid</option>
                                <option value="2" >Paid</option>
                                <option value="3" >Pending</option>
                            </x-forms.select>
                       </x-forms.field>
                        <x-forms.button class="btn btn-sm btn-primary">
                            Submit
                        </x-forms.button>
                    </x-forms.form>
                </div>
            </div>
        </div>
    </x-layout>
@endcan

