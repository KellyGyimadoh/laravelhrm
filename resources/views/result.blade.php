<x-layout theTitle="Workers Search">
    <div class="card">

        <div class="card-body">
            <h5 class="card-title">All Workers</h5>
            <div class="search-bar">
                <form class="search-form d-flex justify-content-end" method="GET" action="query">
                    <input type="text" name="q" placeholder="Search" title="Enter search keyword">
                    <button class=" btn btn-sm btn-primary" type="submit" title="Search"><i
                            class="bi bi-search"></i></button>
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

</x-layout>
