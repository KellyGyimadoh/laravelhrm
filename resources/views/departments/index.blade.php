@props(['query' => ''])
<x-layout theTitle="All Departments" href="/departments">
    <div class="card">
        <div class="card-body">
            <div class="mt-3">
                <a href="/departments">
                    <button class="btn btn-sm btn-primary" type="button" title="Search">
                        View All Departments
                    </button>
                </a>
            </div>

            @if ($query)
                <p>Showing results for: <strong>{{ $query }}</strong></p>
            @endif

            <div class="search-bar mt-3">
                <form class="search-form d-flex justify-content-end" method="GET"
                    action="{{ url('search/department') }}">
                    <input type="text" name="q" placeholder="Search" class="me-2"
                        title="Enter search keyword" value="{{ request('q') }}">
                    <select name="name" class="w-25">
                        <option value="all" {{ request('name') == 'all' ? 'selected' : '' }}>All departments</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->name }}"
                                {{ request('name') == $department->name ? 'selected' : '' }}>
                                {{ ucfirst($department->name) }}
                            </option>
                        @endforeach
                    </select>
                    <button class="btn btn-sm btn-primary" type="submit" title="Search">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
            </div>

            @if ($departments->isEmpty())
                <p class="text-danger">No departments found.</p>
            @else
                <!-- Table with striped rows -->
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Number</th>
                            <th scope="col">Department Name</th>
                            <th scope="col">Department Head</th>
                            <th scope="col">Department Email</th>
                            <th scope="col"> Description</th>
                            <th scope="col"> Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($departments as $index => $department)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $department->name }}</td>
                                <td>
                                    @if ($department->head)
                                        {{ $department->head->firstname . ' ' . $department->head->lastname }}
                                    @else
                                        <em>No head assigned</em>
                                    @endif
                                </td>
                                <td>{{ $department->email }}</td>
                                <td>{{ $department->description }}</td>
                                <td>@if ($department->status===1)
                                    <button class="btn btn-danger fst-italic text-wrap ">Suspended</button>
                                    @else
                                    <button class="btn btn-success">Active</button>
                                @endif</td>
                                <td>
                                    <a href="/departments/{{ $department->id }}">
                                        <button class="btn btn-success">Edit</button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- End Table with striped rows -->
                {{ $departments->links() }}
            @endif
        </div>
    </div>
</x-layout>
