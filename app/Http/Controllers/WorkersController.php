<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\Salary;
use App\Models\User;
use Illuminate\Http\Request;

class WorkersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $workers= User::with('department')->latest()->paginate(5);
       return view('workers.index',['workers'=>$workers]);
    }
    public function workerSalary(Salary $salary,User $user)
    {
        $onesalary=$user->currentSalary;

        return view('salary.show',['user'=>$user,'salary'=>$onesalary]);
    }
    /**
     * Show the form for creating a new resource.
     */

     public function staff(){
        $workers=User::where('role','=','staff')->with('department')->latest()->paginate(5);
        return view('workers.staff.index',['workers'=>$workers]);
     }

     public function admin(){
        $workers=User::where('role','=','admin')->with('department')->latest()->paginate(5);
        return view('workers.admin.index',['workers'=>$workers]);
     }
     public function staffSearch(Request $request)
    {
        // Get the search query
        $query = $request->input('q');

        // Build the query for staff role
        $workersQuery = User::with('department')
            ->where('role', 'staff');

        // Apply search query filtering
        if ($query) {
            $workersQuery->where('firstname', 'LIKE', '%' . $query . '%');
        }

        // Paginate the results
        $workers = $workersQuery->latest()->paginate(4)->appends(['q'=>$query,'role'=>'staff']);

        // Return the view with the workers data
        return view('workers.staff.index', ['workers' => $workers, 'query' => $query]);



    }

    public function adminSearch(Request $request)
    {
        // Get the search query
        $query = $request->input('q');

        // Build the query for admin role
        $workersQuery = User::with('department')
            ->where('role', 'admin');

        // Apply search query filtering
        if ($query) {
            $workersQuery->where('firstname', 'LIKE', '%' . $query . '%');
        }

        // Paginate the results
        $workers = $workersQuery->latest()->paginate(4)->appends(['q'=>$query,'role'=>'admin']);

        // Return the view with the workers data
        return view('workers.admin.index', ['workers' => $workers, 'query' => $query]);
    }
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
