@can('viewAny','App\\Models\User')


<x-layout theTitle="Mark Attendance" href="/attendance/mark">
    <div class="card">
        <div class="card-body">
            <div class="mt-3">

                <x-forms.form id="checkinForm" method="POST" action="/attendance/mark/{{$worker->id}}">
                    <x-forms.input name="" label="FullName" value="{{$worker->firstname.''.$worker->lastname}}" disabled/>
                    <x-forms.input name="" label="Department" value="{{$worker->department->name}}" disabled/>
                    <button class="btn btn-sm btn-primary" type="submit">
                        Mark Present
                    </button>
                </x-forms.form>
            </div>

        </div>
    </div>


</x-layout>
@endcan
