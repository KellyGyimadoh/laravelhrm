@props(['worker'])
<x-layout theTitle="All Workers">
    <div class="card">
        <div class="card-body">
          <h5 class="card-title">{{}}</h5>

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
                @foreach ($workers as $worker )


              <tr>
                <th scope="row">{{$worker->firstname}}</th>
                <td>{{$worker->lastname}}</td>
                <td>{{$worker->email}}</td>
                <td>{{$worker->department->name}}</td>
                <td>{{$worker->role}}</td>
              </tr>
              @endforeach
            </tbody>
            @error($workers)
                <tr>{{$error}}</tr>
            @enderror
          </table>

          <!-- End Table with stripped rows -->

        </div>
      </div>
</x-layout>
