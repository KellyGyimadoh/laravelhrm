@include('components.body.head', ['title' => 'Register Account'])

<body>

    <main>
        <div class="container">

            <section
                class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <div class="d-flex justify-content-center py-4">
                                <a href="index.html" class="logo d-flex align-items-center w-auto">
                                    <img src="assets/img/logo.png" alt="">
                                    <span class="d-none d-lg-block">Register Account</span>
                                </a>
                            </div><!-- End Logo -->

                            <div class="card mb-3">

                                <div class="card-body">


                                    <x-forms.form method="POST" action="register" enctype="multipart/form-data"
                                        novalidate>


                                        <x-forms.input name="firstname" label="Firstname" placeholder="Firstname" />


                                        <x-forms.input name="lastname" label="Lastname" placeholder="Lastname" />

                                        @if (session('googleUser'))
                                        <x-forms.input type="hidden" name="google_id" label=""
                                            value="{{ session('googleUser')->id }}"/>
                                        <x-forms.input type="hidden" name="email" label=""
                                            value="{{ session('googleUser')->email }}"/>
                                            @else
                                            <x-forms.input name="email" label="Email" type="email"
                                            placeholder="man@mail.com" />
                                    @endif




                                        <x-forms.input name="password" label="Password" type="password" />



                                        <x-forms.input name="password_confirmation" label="Confirm Password"
                                            type="password" />

                                        <x-forms.field name="department" label="Department">
                                            <x-forms.select name="department">
                                                <option value="">Select Department</option>
                                                <option value="science">Science</option>
                                                <option value="tech">Tech</option>
                                                <option value="health">Health</option>
                                            </x-forms.select>
                                        </x-forms.field>
                                        <x-forms.input name="image" label="Profile Photo" type="file" />


                                        <x-forms.button class="w-100">Register Account</x-forms.button>

                                        <div class="col-12">
                                            <p class="small mb-0">Already Have an Account? <a href="/">Login</a>
                                            </p>
                                        </div>
                                    </x-forms.form>

                                </div>
                            </div>



                        </div>
                    </div>
                </div>

            </section>

        </div>
    </main><!-- End #main -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    @include('components.body.script')

</body>

</html>
