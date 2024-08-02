<x-layout theTitle="Create Department" href="/departments/register">
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

                    <!-- Profile Edit Form -->
                    <x-forms.form method="POST" action="{{ url('/department') }}" enctype="multipart/form-data"
                        novalidate>


                        <x-forms.input name="image" label="Department Photo" type="file" />
                        <x-forms.input name="name" label="Department Name" placeholder="Department Name" />
                        <x-forms.input name="departmenthead" label="Department Head" placeholder="Head of Department" />
                        <x-forms.input name="email" label="Department Email" type="email"
                            placeholder="man@mail.com" />
                        <x-forms.input name="description" label="Department Description" placeholder="Description" />

                        <x-forms.button class="w-100">Create new Department</x-forms.button>
                    </x-forms.form><!-- End Profile Edit Form -->


                </div>
            </div>
        </div>
    </div>
</x-layout>

<!-- End Bordered Tabs -->
