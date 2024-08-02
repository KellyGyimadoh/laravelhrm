@props(['query'=>''])
<x-layout theTitle="Workers Leave Request" href="/leave">
    <div class="card">

        <div class="card-body">
            <div class="mt-3"><a href="/leave"><button class="btn btn-sm btn-primary" type="submit" title="Search">
                View All Leave Records
            </button></a></div>
            @if($query)
            <p>Showing results for: <strong>{{ $query }}</strong></p>

        @endif

        @if($leaves->isEmpty())
         <p class="text-danger">No Leave Records found.</p>
            <div class="search-bar mt-3">
                <form class="search-form d-flex justify-content-end" method="GET" action="/leave/search">
                    <input
                        type="text"
                        name="q"
                        placeholder="Search"
                        class="me-2"
                        title="Enter search keyword"
                        value="{{ old('q', $query) }}" {{-- Retain the search query after submission --}}

                    >
                    <select name="status" class="w-25">
                        <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All</option>
                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Pending</option>
                        <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Approved</option>
                        <option value="3" {{ request('status') == '3' ? 'selected' : '' }}>Rejected</option>
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
            <form class="search-form d-flex justify-content-end" method="GET" action="/leave/search">
                <input
                    type="text"
                    name="q"
                    placeholder="Search"
                    title="Enter search keyword"
                    class="me-2"
                    value="{{ old('q', $query) }}"{{-- Retain the search query after submission --}}

                >
                <select name="status" class="w-25">
                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All</option>
                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Pending</option>
                    <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Approved</option>
                    <option value="3" {{ request('status') == '3' ? 'selected' : '' }}>Rejected</option>
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
                        <th scope="col">Request Type</th>
                        <th scope="col">Start Date</th>
                        <th scope="col">End Date</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($leaves as $leave)
                        <tr>
                            <th scope="row">{{$loop->iteration }}</th>
                            <th>{{ $leave->user->firstname }}</th>
                            <td>{{ $leave->user->lastname }}</td>
                            <td>{{ $leave->user->department->name }}</td>
                            <td>{{ $leave->type }}</td>
                            <td>{{$leave->start_date}}</td>
                            <td>{{$leave->end_date}}</td>
                            <td>@if ($leave->status===1)
                                <button class="btn btn-warning fst-italic text-wrap ">Pending</button>
                                @elseif($leave->status===2)
                                <button class="btn btn-success">Approved</button>
                                @else
                                <button class="btn btn-danger">Rejected</button>
                            @endif</td>

                            <td><a href="/leave/{{$leave->id}}"><button class="btn btn-success">Edit</button></a>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
                @error($leaves)
                    <tr>{{ $error }}</tr>
                @enderror
            </table>

            <!-- End Table with stripped rows -->
            {{ $leaves->links() }}
        </div>
    </div>
@endif
</x-layout>
