@props(['query'=>''])
<x-layout theTitle="All Staff" href="/workers/staff">
    <div class="card">

        <div class="card-body">
            <div class="mt-3"><a href="/workers/staff"><button class="btn btn-sm btn-primary" type="submit" title="Search">
                View All Staff
            </button></a></div>
            @if($query)
            <p>Showing results for: <strong>{{ $query }}</strong></p>

        @endif

        @if($workers->isEmpty())
         <p class="text-danger">No workers found.</p>
            <div class="search-bar mt-3">
                <form class="search-form d-flex justify-content-end" method="GET" action="../search/staff/">
                    <input
                        type="text"
                        name="q"
                        placeholder="Search"
                        class="me-2"
                        title="Enter search keyword"
                        value="{{ old('q') }}" {{-- Retain the search query after submission --}}

                    >
                    <select name="role" class="w-25">

                        <option value="staff" {{ request('role') }} selected>Staff</option>

                    </select>

                    <button class="btn btn-sm btn-primary" type="submit" title="Search">
                        <i class="bi bi-search"></i>
                    </button>

                    @error('q')
                        <div class="invalid-feedback">{{ $message }}</div> {{-- Show error message --}}
                    @enderror
                </form>
            </div>
        @else
        <div class="search-bar mt-3">
            <form class="search-form d-flex justify-content-end" method="GET" action="../search/staff/">
                <input
                    type="text"
                    name="q"
                    placeholder="Search"
                    title="Enter search keyword"
                    class="me-2"
                    value="{{ old('q') }}" {{-- Retain the search query after submission --}}

                >
                <select name="role" class="w-25">

                    <option value="staff" {{ request('role') == 'staff' ? 'selected' : '' }}>Staff</option>

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
                        <th scope="col">Firstname</th>
                        <th scope="col">Lastname</th>
                        <th scope="col">Email</th>
                        <th scope="col">Department</th>
                        <th scope="col">Role</th>
                        <th scope="col">Position</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($workers as $worker)
                        <tr>
                            <th scope="row">{{ $worker->firstname }}</th>
                            <td>{{ $worker->lastname }}</td>
                            <td>{{ $worker->email }}</td>
                            <td>{{ $worker->department->name }}</td>
                            <td>{{ $worker->role }}</td>
                            <td>{{ $worker->position }}</td>
                            <td>@if ($worker->status===1)
                                <button class="btn btn-danger fst-italic text-wrap disabled">Suspended</button>
                                @else
                                <button class="btn btn-success">Active</button>
                            @endif</td>

                            <td><a href="/dashboardprofile/{{$worker->id}}"><button class="btn btn-success">Edit</button></a>

                            </td>
                        </tr>

                    @endforeach
                </tbody>
                @error($workers)
                    <tr>{{ $error }}</tr>
                @enderror
            </table>

            <!-- End Table with stripped rows -->
            {{ $workers->links() }}
        </div>
    </div>
@endif
</x-layout>
