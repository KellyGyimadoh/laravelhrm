@props(['query' => '', 'searchdate' => ''])

<x-layout theTitle="Salary Records" href="/salary">
    <div class="card">
        <div class="card-body">
            <div class="mt-3">
                <a href="/salary"><button class="btn btn-sm btn-primary" type="submit" title="Search">View All Salary Records</button></a>
            </div>
            @if ($query)
                <p>Showing results for: <strong>{{ $query }}</strong></p>
            @endif

            @if ($salaries->isEmpty())
                <p class="text-danger">No Salary Records found.</p>
            @endif

            <div class="search-bar mt-3">
                <form class="search-form d-flex justify-content-end" method="GET" action="/salary/search">
                    <input type="text" name="q" placeholder="Search" class="me-2" title="Enter search keyword" value="{{ old('q', $query) }}">
                    <input type="date" name="searchdate" placeholder="Search" class="me-2" title="Enter search keyword" value="{{ old('searchdate', $searchdate) }}">

                    <button class="btn btn-sm btn-primary" type="submit" title="Search">
                        <i class="bi bi-search"></i>
                    </button>

                    @error('q')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </form>
            </div>

            @if (!$salaries->isEmpty())
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Number</th>
                            <th scope="col">Firstname</th>
                            <th scope="col">Lastname</th>
                            <th scope="col">Department</th>
                            <th scope="col">Salary</th>
                            <th scope="col">Effective Payment Date</th>
                            <th scope="col">Salary Created At</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($salaries as $salary)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <th>{{ $salary->user->firstname }}</th>
                                <td>{{ $salary->user->lastname }}</td>
                                <td>{{ $salary->user->department->name }}</td>
                                <td>{{ $salary->amount }}</td>
                                <td>{{ $salary->effective_date }}</td>
                                <td>{{ $salary->created_at }}</td>

                                <td><a href="/salary/{{ $salary->id }}"><button class="btn btn-success">Edit</button></a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $salaries->links() }}
            @endif
        </div>
    </div>
</x-layout>
