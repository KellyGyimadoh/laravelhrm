@can('viewAny','App\\Models\User')


@props(['theTitle', 'href'])

@php
    $currentDate = date('l, F j, Y');
@endphp
@include('components.body.head', ['title' => $theTitle])

<body>

    <!-- ======= Header ======= -->
    @include('components.body.header')
    <!-- End Header -->

    <!-- ======= Sidebar ======= -->
   @include('components.body.sidebar')
    <!-- End Sidebar-->

    <main id="main" class="main">
        <div class="d-flex align-items-end flex-column mb-3" style="height: 10px;">
            <div><h4>{{ $currentDate }}</h4></div>
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-clock me-2"></i> <!-- Icon with margin-right -->
                <div id="clock">00:00:00</div>
            </div>
        </div>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show alertbox" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('warning'))
        <div class="alert alert-success alert-dismissible fade show alertbox" role="alert">
            {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
        @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show alertbox" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
        <x-page-heading title={{$theTitle}} href="{{$href}}" />
        <!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">
                <div id="alertBox" class="alert alert-success alert-dismissible fade" role="alert" style="display: none;">
                    <span id="alertMessage"></span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                {{ $slot }}


            </div>
        </section>
    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    @include('components.body.footer')
    <!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    @include('components.body.script')
</body>

</html>
@endcan
