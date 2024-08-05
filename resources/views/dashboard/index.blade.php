@auth
    <x-layout theTitle="Dashboard" href="/dashboard">

        <h3>Welcome {{ $user->firstname }}</h3>
        <div class="row mb-5">

            <!-- Sales Card -->
            <div class="col-xxl-4 col-md-6">
                <div class="card info-card sales-card">


                    <div class="filter">
                        <div class="dropdown">
                            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="filterDropdown">
                                <li class="dropdown-header text-start">
                                    <h6>Filter</h6>
                                </li>
                                <li>
                                    <select name="dashboardselect" id="filterSelect" class="form-select form-select-sm">
                                        <option value="all" selected>All</option>
                                        <option value="admins">Admins</option>
                                        <option value="staff">Staff</option>
                                    </select>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card-body">
                        <h5 class="card-title">Total Workers| <span id="workertype"></span></h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="fa-solid fa-users"></i>
                            </div>
                            <div class="ps-3">
                                <h6 id="workercount"></h6>
                                <span id="percentageChange" class="text-success small pt-1 fw-bold">12%</span> <span
                                    class="text-muted small pt-2 ps-1">increase</span>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-xxl-4 col-md-6">
                <div class="card info-card sales-card">
                    <div class="filter">
                        <div class="dropdown">
                            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="filterDropdown">
                                <li class="dropdown-header text-start">
                                    <h6>Filter</h6>
                                </li>
                                <li>
                                    <select id="filterworkersactive" class="form-select form-select-sm">
                                        <option value="all" selected>All</option>
                                        <option value="admins">Admins</option>
                                        <option value="staff">Staff</option>
                                    </select>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card-body">
                        <h5 class="card-title">Total Workers Active| <span class="workeractivetype"></span></h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-person-plus-fill"></i>
                            </div>
                            <div class="ps-3">
                                <h6 id="workeractivecount"></h6>
                                <span id="percentageChange" class="text-success small pt-1 fw-bold">12%</span> <span
                                    class="text-muted small pt-2 ps-1">increase</span>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-xxl-4 col-md-6">
                <div class="card info-card sales-card">


                    <div class="filter">
                        <div class="dropdown">
                            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="filterDropdown">
                                <li class="dropdown-header text-start">
                                    <h6>Filter</h6>
                                </li>
                                <li>
                                    <select id="filterworkersuspended" class="form-select form-select-sm">
                                        <option value="all" selected>All</option>
                                        <option value="admins">Admins</option>
                                        <option value="staff">Staff</option>
                                    </select>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card-body">
                        <h5 class="card-title">Total Workers Suspended| <span class="workersuspendedtype"></span></h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-person-x"></i>
                            </div>
                            <div class="ps-3">
                                <h6 id="workersuspendedcount"></h6>
                                <span id="percentageChange" class="text-success small pt-1 fw-bold">12%</span> <span
                                    class="text-muted small pt-2 ps-1">increase</span>

                            </div>
                        </div>
                    </div>

                </div>
            </div><!-- End Worker count Card -->
            <div class="col-xxl-4 col-md-6">
                <div class="card info-card sales-card">


                    <div class="card-body">
                        <h5 class="card-title">Total Department Available| <span id="departmenttype"></span></h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="fa-solid fa-users"></i>
                            </div>
                            <div class="ps-3">
                                <h6 id="departmenttotalcount"></h6>
                                <span class="text-success small pt-1 fw-bold">Number of Heads</span> <span
                                    id="departmentheadcount" class="text-muted small pt-2 ps-1">0</span>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-xxl-4 col-md-6">
                <div class="card info-card sales-card">


                    <div class="filter">
                        <div class="dropdown">
                            <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                    class="bi bi-three-dots"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="filterDropdown">
                                <li class="dropdown-header text-start">
                                    <h6>Filter</h6>
                                </li>
                                <li>
                                    <select id="filterSelectDepartmentActive" class="form-select form-select-sm">
                                        <option value="all" selected>All</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->name }}">{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card-body">
                        <h5 class="card-title">Total Department Active|<span id="departmentactivetype"></span></h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="fa-solid fa-building-user"></i>
                            </div>
                            <div class="ps-3">
                                <h6 id="departmentactivecount"></h6>
                                <span class="text-success small pt-1 fw-bold">Number of Heads</span> <span
                                   id="departmentactiveheadcount" class="text-muted small pt-2 ps-1">0</span>

                                    <span class="text-success small pt-1 fw-bold">Head of department</span> <span
                                   id="departmenthead" class="text-muted small pt-2 ps-1">0</span>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-xxl-4 col-md-6">
                <div class="card info-card sales-card">


                    <div class="filter">
                        <div class="dropdown">
                            <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                    class="bi bi-three-dots"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="filterDropdown">
                                <li class="dropdown-header text-start">
                                    <h6>Filter</h6>
                                </li>
                                <li>
                                    <select id="filterSelectDepartmentSuspended" class="form-select form-select-sm">
                                        <option value="all" selected>All</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->name }}">{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card-body">
                        <h5 class="card-title">Total Department Suspended| <span id="departmenttype"></span></h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="fa-solid fa-users"></i>
                            </div>
                            <div class="ps-3">
                                <h6 id="departmentsuspendedcount"></h6>
                                <span id="percentageChange" class="text-success small pt-1 fw-bold">Number of Heads</span>
                                <span class="text-muted small pt-2 ps-1">0</span>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- End Department Card -->
            <div class="col-xxl-4 col-md-6">
                <div class="card info-card sales-card">


                    <div class="filter">
                        <div class="dropdown">
                            <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                    class="bi bi-three-dots"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="filterDropdown">
                                <li class="dropdown-header text-start">
                                    <h6>Filter</h6>
                                </li>
                                <li>
                                    <select id="filterPresent" class="form-select form-select-sm">
                                        <option value="all" selected>All</option>
                                        <option value="admins">Admins</option>
                                        <option value="staff">Staff</option>
                                    </select>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card-body">
                        <h5 class="card-title">Total Workers Present Today|<span id="workertypepresent"></span></h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-person-check-fill"></i>
                            </div>
                            <div class="ps-3">
                                <h6 id="workercountpresent"></h6>
                                <span id="percentageChange" class="text-success small pt-1 fw-bold">12%</span> <span
                                    class="text-muted small pt-2 ps-1">increase</span>

                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Total Workers Absent Today<span id="workertypeabsent"></span></h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-person-dash-fill"></i>
                            </div>
                            <div class="ps-3">
                                <h6 id="workercountabsent"></h6>
                                <span id="percentageChange" class="text-success small pt-1 fw-bold">12%</span> <span
                                    class="text-muted small pt-2 ps-1">increase</span>

                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Total Workers Late Today<span id="workertypepresent"></span></h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-people-fill"></i>
                            </div>
                            <div class="ps-3">
                                <h6 id="workercountlate"></h6>
                                <span id="percentageChange" class="text-success small pt-1 fw-bold">12%</span> <span
                                    class="text-muted small pt-2 ps-1">increase</span>

                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Total Workers on Leave Today<span id="workertypepresent"></span></h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-calendar2-day-fill"></i>
                            </div>
                            <div class="ps-3">
                                <h6 id="workercountleave"></h6>
                                <span id="percentageChange" class="text-success small pt-1 fw-bold">12%</span> <span
                                    class="text-muted small pt-2 ps-1">increase</span>

                            </div>
                        </div>
                    </div>

                </div>
            </div><!-- End Workers present Today Card -->



            <!-- Revenue Card -->
            <div class="col-xxl-4 col-md-6">
                <div class="card info-card revenue-card">

                    <div class="filter">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li class="dropdown-header text-start">
                                <h6>Filter</h6>
                            </li>

                            <li><a class="dropdown-item" href="#">Today</a></li>
                            <li><a class="dropdown-item" href="#">This Month</a></li>
                            <li><a class="dropdown-item" href="#">This Year</a></li>
                        </ul>
                    </div>

                    <div class="card-body">
                        <h5 class="card-title">Revenue <span>| This Month</span></h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-currency-dollar"></i>
                            </div>
                            <div class="ps-3">
                                <h6>$3,264</h6>
                                <span class="text-success small pt-1 fw-bold">8%</span> <span
                                    class="text-muted small pt-2 ps-1">increase</span>

                            </div>
                        </div>
                    </div>

                </div>
            </div><!-- End Revenue Card -->

            <!-- Customers Card -->
            <div class="col-xxl-4 col-xl-12">

                <div class="card info-card customers-card">

                    <div class="filter">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li class="dropdown-header text-start">
                                <h6>Filter</h6>
                            </li>

                            <li><a class="dropdown-item" href="#">Today</a></li>
                            <li><a class="dropdown-item" href="#">This Month</a></li>
                            <li><a class="dropdown-item" href="#">This Year</a></li>
                        </ul>
                    </div>

                    <div class="card-body">
                        <h5 class="card-title">Customers <span>| This Year</span></h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="ps-3">
                                <h6>1244</h6>
                                <span class="text-danger small pt-1 fw-bold">12%</span> <span
                                    class="text-muted small pt-2 ps-1">decrease</span>

                            </div>
                        </div>

                    </div>
                </div>


            </div>
        </div>
    </x-layout>

@endauth
