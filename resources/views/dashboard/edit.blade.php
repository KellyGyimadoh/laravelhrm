
<x-layout theTitle="{{$user->firstname}} Profile" href="/dashboard/{{ $user->id }}">
    <div class="row">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                    <img src="{{ asset('storage/'.$user->image) }}" class="profile-image" alt="Profile" class="rounded-circle">
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

        <div class="col-xl-8">
            <div class="card">
                <div class="card-body pt-3">
                    <!-- Bordered Tabs -->
                    <x-tabs.navtabs />
                    <x-tabs.tab-content>
                        <x-tabs.tab-pane id="profile-overview">
                            <h5 class="card-title">About</h5>
                            <p class="small fst-italic">Sunt est soluta temporibus accusantium neque nam maiores cumque
                                temporibus. Tempora libero non est unde veniam est qui dolor. Ut sunt iure rerum quae
                                quisquam autem eveniet perspiciatis odit. Fuga sequi sed ea saepe at unde.</p>

                            <h5 class="card-title">Profile Details</h5>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label ">Full Name</div>
                                <div class="col-lg-9 col-md-8">{{ $user->firstname . ' ' . $user->lastname }}</div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Department</div>
                                <div class="col-lg-9 col-md-8">{{ $user->department->name }}</div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Email</div>
                                <div class="col-lg-9 col-md-8">{{ $user->email }}</div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Role</div>
                                <div class="col-lg-9 col-md-8">{{ $user->role }}</div>
                            </div>
                        </x-tabs.tab-pane>

                        <x-tabs.tab-pane id="profile-edit" show="true" >
                            <!-- Profile Edit Form -->
                            <x-forms.form method="POST" action="{{ url('/dashboardprofile/' . $user->id) }}"
                                enctype="multipart/form-data" novalidate>

                                @method('PATCH')
                                <div class="row mb-3">
                                    <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile
                                        Image</label>
                                    <div class="col-md-8 col-lg-9 mt-3">
                                        <img src="{{ asset($user->image) }}" alt="Profile" class="profile-image">
                                        <div class="pt-2">
                                            <a href="#" class="btn btn-primary btn-sm"
                                                title="Upload new profile image"><i class="bi bi-upload"></i></a>
                                            <a href="#" class="btn btn-danger btn-sm"
                                                title="Remove my profile image"><i class="bi bi-trash"></i></a>
                                        </div>
                                    </div>
                                </div>

                                <x-forms.input name="image" label="Profile Photo" type="file" />
                                <x-forms.input name="firstname" label="Firstname" placeholder="Firstname"
                                    value="{{ $user->firstname }}" />
                                <x-forms.input name="lastname" label="Lastname" placeholder="Lastname"
                                    value="{{ $user->lastname }}" />
                                <x-forms.input name="email" label="Email" type="email" placeholder="man@mail.com"
                                    value="{{ $user->email }}" />

                                <x-forms.field name="department" label="Department-> {{ $user->department->name }}">
                                    <x-forms.select name="department">
                                        <option value="">Select Department</option>

                                        {{-- Loop through an array of departments to dynamically generate options --}}
                                        @foreach (['science', 'tech', 'health'] as $department)
                                            <option value="{{ $department }}"
                                                {{ $user->department->name === $department ? 'selected' : '' }}>
                                                {{ ucfirst($department) }}
                                            </option>
                                        @endforeach
                                    </x-forms.select>
                                </x-forms.field>

                                <x-forms.field name="role" label="Role-> {{ $user->role }}">
                                    <x-forms.select name="role">
                                        <option value="">Select Role</option>
                                        @if ($user->role === 'admin')
                                            @foreach (['admin', 'staff'] as $role)
                                                <option value="{{ $role }}"
                                                    {{ $user->role === $role ? 'selected' : '' }}>
                                                    {{ ucfirst($role) }}</option>
                                            @endforeach
                                        @else
                                            <option value="staff" selected>Staff</option>
                                        @endif
                                    </x-forms.select>
                                </x-forms.field>
                                <x-forms.field name="position" label="Position-> {{ $user->position }}">
                                    <x-forms.select name="position">
                                        <option value="">Select Position</option>
                                        @if ($user->role === 'admin')
                                            @foreach (['ranked', 'unranked','head'] as $position)
                                                <option value="{{ $position }}"
                                                    {{ $user->position === $position ? 'selected' : '' }}>
                                                    {{ ucfirst($position) }}</option>
                                            @endforeach
                                        @else
                                            <option value="{{$user->position}}" selected>{{ucfirst($user->position)}}</option>
                                        @endif
                                    </x-forms.select>
                                </x-forms.field>

                                <x-forms.button class="w-100">Update</x-forms.button>
                            </x-forms.form><!-- End Profile Edit Form -->
                        </x-tabs.tab-pane>

                        <x-tabs.tab-pane id="profile-settings">
                            <!-- Settings Form -->
                            @can('create', 'App\\Models\User')
                              <div class="mt-3 mb-5">  <x-forms.form method="POST" action="{{ url('/dashboardprofile/' . $user->id) }}"
                                    class="mt-3 mb-5">
                                    @csrf <!-- Added CSRF token -->
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete User</button>
                                </x-forms.form></div>
                               @if ($user->status===2)
                               <div class="mt-3">
                                <x-forms.form method="POST" action="{{ url('/dashboardprofile/' . $user->id.'/suspend') }}"
                                   class="mt-3 mb-3">
                                   @csrf <!-- Added CSRF token -->
                                   @method('PATCH')

                                   <button type="submit" class="btn btn-danger">Suspend User</button>
                               </x-forms.form>
                            </div>
                               @else
                               <div class="mt-3">
                                <x-forms.form method="POST" action="{{ url('/dashboardprofile/' .$user->id.'/suspend') }}"
                                   class="mt-3 mb-3">
                                   @csrf <!-- Added CSRF token -->
                                   @method('PATCH')

                                   <button type="submit" class="btn btn-success">Activate User</button>
                               </x-forms.form>
                            </div>
                               @endif

                            @endcan
                            <!-- End settings Form -->
                        </x-tabs.tab-pane>

                        <x-tabs.tab-pane id="profile-change-password">
                            <!-- Change Password Form -->
                            <x-forms.form method="POST" id="passwordform" action="{{ url('/dashboardprofile/' .$user->id.'/changepassword') }}"> <!-- Example action -->
                                @csrf <!-- Added CSRF token -->
                                <div class="row mb-3">
                                    <input type="text" value="{{$user->id}}" name="id" id="userid" hidden>
                                    <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current
                                        Password</label>
                                    <div class="col-md-8 col-lg-9">
                                        <x-forms.input name="password" label=""  type="password" class="form-control"
                                            id="currentPassword"/>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New
                                        Password</label>
                                    <div class="col-md-8 col-lg-9">
                                        <x-forms.input name="newpassword" label="" type="password" class="form-control"
                                            id="newPassword"/>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="newpassword_confirmation" class="col-md-4 col-lg-3 col-form-label">Re-enter New
                                        Password</label>
                                    <div class="col-md-8 col-lg-9">
                                        <x-forms.input name="newpassword_confirmation" label="" type="password" class="form-control"
                                            id="newpassword_confirmation"/>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Change Password</button>
                                </div>
                            </x-forms.form><!-- End Change Password Form -->
                        </x-tabs.tab-pane>
                    </x-tabs.tab-content>
                </div>
            </div>
        </div>
    </div>
</x-layout>

<!-- End Bordered Tabs -->
