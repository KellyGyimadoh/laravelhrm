@props(['query' => '', 'selectedDepartment' => '', 'selectedDate' => ''])
<x-layout theTitle="All Workers Attendance Record" href="/attendance/history">
    <div class="card">
        <div class="card-body">
            <div class="mt-3">
                <a href="/attendance/history">
                    <button class="btn btn-sm btn-primary" type="submit" title="Search">
                        View All Workers
                    </button>
                </a>
            </div>
            <div class="d-flex justify-content-end">
                <h4> Date Today: {{ date('Y-m-d') }}</h4>
            </div>

            @if ($query)
                <p>Showing results for: <strong>{{ $query }}</strong></p>
            @endif

            @if ($workers->isEmpty())
                <p class="text-danger">No workers found.</p>
            @else
                <div class="search-bar mt-3">
                    <form class="search-form d-flex justify-content-end" method="GET"
                        action="/attendance/history/search">
                        <input type="text" name="q" placeholder="Search User" class="me-2"
                            title="Enter search keyword" value="{{ old('q', $query) }}"> {{-- Retain the search query after submission --}}
                        <input type="date" name="datesearch" value="{{ old('datesearch', $selectedDate) }}" />
                        <select name="department" class="w-25">
                            <option value="all" {{ $selectedDepartment == 'all' ? 'selected' : '' }}>All
                                Workers/Departments</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->name }}"
                                    {{ $selectedDepartment == $department->name ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                        <button class="btn btn-sm btn-primary" type="submit" title="Search">
                            <i class="bi bi-search"></i>
                        </button>
                        @error('q')
                            <div class="invalid-feedback">{{ $message }}</div> {{-- Show error message --}}
                        @enderror
                    </form>

                </div>

                <!-- Table with stripped rows -->
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Number</th>
                            <th scope="col">Firstname</th>
                            <th scope="col">Lastname</th>
                            <th scope="col">Department</th>
                            <th scope="col">Role</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($workers as $worker)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <th>{{ $worker->firstname }}</th>
                                <td>{{ $worker->lastname }}</td>
                                <td>{{ $worker->department->name }}</td>
                                <td>{{ $worker->role }}</td>
                                <td>
                                    @if ($worker->attendance_for_date)
                                        @switch($worker->attendance_for_date->status)
                                            @case(1)
                                                <button class="btn btn-danger fst-italic text-wrap disabled">Absent</button>
                                            @break

                                            @case(2)
                                                <button class="btn btn-success">Present</button>
                                            @break

                                            @case(3)
                                                <button class="btn btn-light">On Leave</button>
                                            @break

                                            @case(4)
                                                <button class="btn btn-warning">Late</button>
                                            @break

                                            @default
                                                <button class="btn btn-secondary">Unmarked</button>
                                        @endswitch
                                    @else
                                        <button class="btn btn-danger fst-italic text-wrap disabled">Absent</button>
                                    @endif
                                </td>
                                <td>
                                        @if ($worker->attendance_for_today)

                                        {{ $worker->attendance_for_today->check_in_time }}
                                        @else
                                        {{'N/A'}}
                                        @endif
                                    </td>
                                    <td>
                                        <a href="/dashboardprofile/{{ $worker->id }}">
                                            <button class="btn btn-success">Edit</button>
                                        </a>
                                    </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- End Table with stripped rows -->
                {{ $workers->links() }}
            @endif
        </div>
    </div>
</x-layout>
