@can('create','App\\Models\User')


<x-layout theTitle="Department Profile" href="/departments/{{$department->id}}">
    <div class="row">
        {{-- <div class="col-xl-4">
            <div class="card">
                <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                    <img src="{{ asset($user->image) }}" alt="Profile" class="rounded-circle">
                    <h2>{{ $user->firstname . ' ' . $user->lastname }}</h2>
                    <h3>{{ $user->department->name }}</h3>
                    <div class="social-links mt-2">
                        <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>
            </div>
        </div>
        department logo
        --}}

        <div class="col-xl-8">
            <div class="card">
                <div class="card-body pt-3">
                    <!-- Bordered Tabs -->
                    <x-tabs.navtabs />
                    <x-tabs.tab-content>
                        <x-tabs.tab-pane id="profile-overview">
                            <h5 class="card-title">About</h5>
                            <p class="small fst-italic">{{$department->description}}</p>

                            <h5 class="card-title">Department Profile Details</h5>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label ">Department Name</div>
                                <div class="col-lg-9 col-md-8">{{ $department->name }}</div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Department Number of Workers</div>
                                <div class="col-lg-9 col-md-8">{{ $department->users->count() }}</div>
                            </div>

                        </x-tabs.tab-pane>

                        <x-tabs.tab-pane id="profile-edit">
                            <!-- Profile Edit Form -->
                            <x-forms.form method="POST" action="{{ url('/departments/' . $department->id) }}"
                                enctype="multipart/form-data" novalidate>

                                @method('PATCH')
                                {{-- <div class="row mb-3">
                                    <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile
                                        Image</label>
                                    <div class="col-md-8 col-lg-9">
                                        <img src="{{ asset($department->image) }}" alt="Profile">
                                        <div class="pt-2">
                                            <a href="#" class="btn btn-primary btn-sm"
                                                title="Upload new profile image"><i class="bi bi-upload"></i></a>
                                            <a href="#" class="btn btn-danger btn-sm"
                                                title="Remove my profile image"><i class="bi bi-trash"></i></a>
                                        </div>
                                    </div>
                                </div> --}}

                                <x-forms.input name="image" label="Profile Photo" type="file" />
                                <x-forms.input name="name" label="Department Name" placeholder="Department Name"
                                    value="{{ $department->name }}" />
                                    <x-forms.input
                                    name="departmenthead"
                                    label="Department Head"
                                    placeholder="Head of Department"
                                    value="{{ $department->head ? $department->head->firstname : 'no head' }}"
                                />
                                <x-forms.input name="email" label="Department Email" type="email" placeholder="man@mail.com"
                                    value="{{ $department->email }}" />
                                    <x-forms.input name="description" label="Department Description" placeholder="Description"
                                    value="{{ $department->description }}" />

                                <x-forms.button class="w-100">Update Department</x-forms.button>
                            </x-forms.form><!-- End Profile Edit Form -->
                        </x-tabs.tab-pane>

                        <x-tabs.tab-pane id="profile-settings">
                            <!-- Settings Form -->
                            @can('create', 'App\\Models\User')
                            @if ($department->status===2)
                            <x-forms.form method="POST" action="{{ url('/department/' . $department->id.'/suspend') }}"
                                class="mt-3 mb-3">
                                @method('PATCH')
                               <!-- Added CSRF token -->

                                <button type="submit" class="btn btn-danger">Suspend Department</button>
                            </x-forms.form>
                            @else
                            <x-forms.form method="POST" action="{{ url('/department/' . $department->id.'/suspend') }}"
                                class="mt-3 mb-3">
                                @method('PATCH')
                               <!-- Added CSRF token -->

                                <button type="submit" class="btn btn-success">Activate Department</button>
                            </x-forms.form>
                            @endif

                            <div class="mt-5 mb-5"> <x-forms.divider class="mt-5 mb-3"/></div>
                            <x-forms.form method="POST" action="{{ url('/department/' . $department->id) }}"
                                class="mt-5">
                                <!-- Added CSRF token -->
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete Department</button>
                            </x-forms.form>
                            @endcan
                            <!-- End settings Form -->
                        </x-tabs.tab-pane>


                    </x-tabs.tab-content>
                </div>
            </div>
        </div>
    </div>
</x-layout>
@endcan
<!-- End Bordered Tabs -->
