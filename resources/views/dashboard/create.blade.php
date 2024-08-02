@can('create','App\\Models\User')
<x-layout theTitle="Create User" href="/workers/register">

    <x-forms.form method="POST"  action="../register" enctype="multipart/form-data" novalidate>
        <x-forms.input name="image" label="Profile Photo" type="file" />
        <x-forms.input name="firstname" label="Firstname" placeholder="Firstname"/>


        <x-forms.input name="lastname" label="Lastname" placeholder="Lastname"  />


        <x-forms.input name="email" label="Email" type="email" placeholder="man@mail.com"  />
        <x-forms.input name="password" label="Password" type="password" />



        <x-forms.input name="password_confirmation" label="Confirm Password"
            type="password" />

            <x-forms.field name="department" label="Department">
                <x-forms.select name="department">
                    <option value="">Select Department</option>

                    {{-- Loop through an array of departments to dynamically generate options --}}
                    @foreach(['science', 'tech', 'health'] as $department)
                        <option value="{{ $department }}">
                            {{ ucfirst($department) }}
                        </option>
                    @endforeach
                </x-forms.select>
            </x-forms.field>
        <x-forms.field name="role" label="Role">
            <x-forms.select name="role">
                <option value="">Select Role</option>
                @foreach (['admin','staff'] as $role )
                <option value="{{$role}}" >{{ucfirst($role)}}</option>

                @endforeach


            </x-forms.select>
        </x-forms.field>
        <x-forms.field name="position" label="Position">
            <x-forms.select name="position">
                <option value="">Select Position</option>

                {{-- Loop through an array of departments to dynamically generate options --}}
                @foreach(['unranked', 'ranked', 'head'] as $position)
                    <option value="{{ $position }}">
                        {{ ucfirst($position) }}
                    </option>
                @endforeach
            </x-forms.select>
        </x-forms.field>
         <x-forms.button class="w-100">Register New User</x-forms.button>

    </x-forms.form>
</x-layout>
@endcan
