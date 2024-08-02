@props(['query' => ''])
<x-layout theTitle="{{$worker->firstname}} Leave Requests" href="/leave/status/{{$worker->id}}">
    <div class="card">
        <div class="card-body">
            <div class="mt-3">
                <a href="/leave/status/{{ $worker->id }}"><button class="btn btn-sm btn-primary" type="submit"
                        title="Search">View All Leave Records</button></a>
            </div>
            @if ($query)
                <p>Showing results for:
                    @switch($query)
                        @case(1)
                            <strong>Pending</strong>
                        </p>
                    @break

                    @case(2)
                        <strong>Approved</strong></p>
                    @break

                    @case(3)
                        <strong>Rejected</strong></p>
                    @break

                    @default
                    <strong></strong></p>
                @endswitch
            @endif

            @if ($leave->isEmpty())
                <p class="text-danger">No Leave Records found.</p>
            @endif
            <div class="search-bar mt-3">
                <form class="search-form d-flex justify-content-end" method="GET"
                    action="/leave/status/{{ $worker->id }}/search">
                    <input type="text" name="q" placeholder="Search" title="Enter search keyword"
                        class="me-2" value="{{ old('q') }}" {{-- Retain the search query after submission --}}>
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
                    @foreach ($leave as $leaveItem)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <th>{{ $leaveItem->user->firstname }}</th>
                            <td>{{ $leaveItem->user->lastname }}</td>
                            <td>{{ $leaveItem->user->department->name }}</td>
                            <td>{{ $leaveItem->type }}</td>
                            <td>{{ $leaveItem->start_date }}</td>
                            <td>{{ $leaveItem->end_date }}</td>
                            <td>
                                @if ($leaveItem->status === 1)
                                    <button class="btn btn-warning fst-italic text-wrap">Pending</button>
                                @elseif($leaveItem->status === 2)
                                    <button class="btn btn-success">Approved</button>
                                @else
                                    <button class="btn btn-danger">Rejected</button>
                                @endif
                            </td>
                            <td><a href="/leave/{{ $leaveItem->id }}"><button class="btn btn-success">Edit</button></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                @error('leave')
                    <tr>{{ $message }}</tr>
                @enderror
            </table>
            <!-- End Table with stripped rows -->
            {{ $leave->links() }}
        </div>
    </div>
</x-layout>
