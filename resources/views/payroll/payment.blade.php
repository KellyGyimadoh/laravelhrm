@props(['query' => '', 'status' => ''])
<x-layout theTitle="Make Payroll Payment" href="/payroll/payment">
    <div class="card">
        <div class="card-body">
            <div class="mt-3">
                <a href="/payroll"><button class="btn btn-sm btn-primary" type="submit" title="Search">View All Payroll Records</button></a>
            </div>
            @if ($query)
                <p>Showing results for: <strong>{{ $query }}</strong></p>
            @endif

            @if ($payrolls->isEmpty())
                <p class="text-danger">No Payroll Records found.</p>
            @endif

            <div class="search-bar mt-3">
                <form class="search-form d-flex justify-content-end" method="GET" action="{{ url('/payroll/paymentsearch') }}">
                    <input type="text" name="q" placeholder="Search" class="me-2" title="Enter search keyword" value="{{ old('q', $query) }}">
                    <select name="status" class="w-25">
                        <option value="all" {{ $status == 'all' ? 'selected' : '' }}>All</option>
                        <option value="1" {{ $status == '1' ? 'selected' : '' }}>Unpaid</option>
                        <option value="2" {{ $status == '2' ? 'selected' : '' }}>Paid</option>
                        <option value="3" {{ $status == '3' ? 'selected' : '' }}>Pending</option>
                    </select>
                    <button class="btn btn-sm btn-primary" type="submit" title="Search">
                        <i class="bi bi-search"></i>
                    </button>

                    @error('q')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </form>
            </div>

            @if (!$payrolls->isEmpty())
                <form method="POST" action="{{ url('/payroll/process-payments') }}">
                    @csrf
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col"><input type="checkbox" id="select-all"></th>
                                <th scope="col">Number</th>
                                <th scope="col">Firstname</th>
                                <th scope="col">Lastname</th>
                                <th scope="col">Department</th>
                                <th scope="col">Salary</th>
                                <th scope="col">Pay Date</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payrolls as $payroll)
                                <tr>
                                    <td><input type="checkbox" name="payroll_ids[]" value="{{ $payroll->id }}"></td>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <th>{{ $payroll->user->firstname }}</th>
                                    <td>{{ $payroll->user->lastname }}</td>
                                    <td>{{ $payroll->user->department->name }}</td>
                                    <td>{{ $payroll->latest_salary }}</td>
                                    <td>{{ $payroll->paydate }}</td>
                                    <td>
                                        @if ($payroll->status === 1)
                                            <button class="btn btn-warning fst-italic text-wrap">Unpaid</button>
                                        @elseif($payroll->status === 2)
                                            <button class="btn btn-success">Paid</button>
                                        @else
                                            <button class="btn btn-danger">Pending</button>
                                        @endif
                                    </td>
                                    <td><a href="/payroll/{{ $payroll->id }}"><button type="button" class="btn btn-success">Edit</button></a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $payrolls->links() }}
                    <button type="submit" class="btn btn-primary mt-3">Process Selected Payments</button>
                </form>
            @endif
        </div>
    </div>
</x-layout>


