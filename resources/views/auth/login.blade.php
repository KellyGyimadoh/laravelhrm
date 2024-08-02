@include('components.body.head', ['title' => 'Login'])

<body>

    <main>
        <div class="container">

            <section
                class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <div class="d-flex justify-content-center py-4">
                                <a href="/" class="logo d-flex align-items-center w-auto">
                                    <img src="assets/img/logo.png" alt="">
                                    <span class="d-none d-lg-block">Login To Your Account</span>
                                </a>
                            </div><!-- End Logo -->
                            <div id="alertBox" class="alert alert-success alert-dismissible fade" role="alert"
                                style="display: none;">
                                <span id="alertMessage"></span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>

                            <div class="card mb-3">

                                <div class="card-body">


                                    <x-forms.form id="loginForm" method="POST" class="row g-3 needs-validation"
                                        novalidate>
                                        <x-forms.input name="email" label="Email" type="email"
                                            placeholder="man@mail.com" />
                                        <x-forms.input name="password" label="Password" type="password" />
                                        <x-forms.divider />
                                        <x-forms.checkbox name="rememberme" label="Remember Me" />
                                        <x-forms.button class="w-100">Login</x-forms.button>
                                        <div class="col-12">
                                            <p class="small mb-0">Don't have an account? <a href="/register">Create an
                                                    account</a></p>
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
