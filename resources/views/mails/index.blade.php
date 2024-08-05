@props(['query'=>''])
<x-layout theTitle="All mails" href="/mails">
    <div class="card">

        <div class="card-body">
            <div class="mt-3"><a href="/mails"><button class="btn btn-sm btn-primary" type="submit" title="Search">
                View All mail
            </button></a></div>
            @if($query)
            <p>Showing results for: <strong>{{ $query }}</strong></p>

        @endif

        @if($mails->isEmpty())
         <p class="text-danger">No mails found.</p>
            <div class="search-bar mt-3">
                <form class="search-form d-flex justify-content-end" method="GET" action="/mails/search">
<input type="date" name="searhdate"/>
                    <input
                        type="text"
                        name="q"
                        placeholder="Search Recipient Email"
                        class="me-2"
                        title="Enter search keyword"
                        value="{{ old('q') }}" {{-- Retain the search query after submission --}}

                    >
                    <select name="role" class="w-25">
                        <option value="all" {{ request('role') == 'all' ? 'selected' : '' }}>All mails</option>
                        <option value="staff" {{ request('role') == 'staff' ? 'selected' : '' }}>Staff</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
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
            <form class="search-form d-flex justify-content-end" method="GET" action="/mails/search">
                <input type="date" name="searhdate"/>
                <input
                    type="text"
                    name="q"
                    placeholder="Search Recipient Email"
                    title="Enter search keyword"
                    class="me-2"
                    value="{{ old('q') }}" {{-- Retain the search query after submission --}}

                >
                <select name="role" class="w-25">
                    <option value="all" {{ request('role') == 'all' ? 'selected' : '' }}>All</option>
                    <option value="staff" {{ request('role') == 'staff' ? 'selected' : '' }}>Staff</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
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
                        <th scope="col">Sender</th>
                        <th scope="col">Subject</th>
                        <th scope="col">Body</th>
                        <th scope="col">Recipient</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mails as $mail)
                        <tr>
                            <th scope="row">{{$loop->iteration }}</th>
                            <th>{{ $mail->user->firstname }}</th>
                            <td>{{ $mail->subject }}</td>
                            <td>{{ $mail->body }}</td>
                            <td>{{ $mail->recipient}}</td>

                            <td><a href="/mails/{{$mail->id}}"><button class="btn btn-success">Edit</button></a>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
                @error($mails)
                    <tr>{{ $error }}</tr>
                @enderror
            </table>

            <!-- End Table with stripped rows -->
            {{ $mails->links() }}
        </div>
    </div>
@endif
</x-layout>
