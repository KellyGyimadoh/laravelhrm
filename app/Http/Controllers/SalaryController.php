<?php

namespace App\Http\Controllers;

use App\Models\Salary;
use App\Http\Requests\StoreSalaryRequest;
use App\Http\Requests\UpdateSalaryRequest;
use App\Models\Payroll;
use App\Models\User;
use App\Services\SearchService;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    protected $searchservice;
    public function __construct(SearchService $searchService){
        $this->searchservice=$searchService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()

    {
        $salaries=Salary::with('user')->latest()->paginate(5);
        return  view('salary.index',['salaries'=>$salaries]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users=User::with('salaries')->get();
        return view('salary.create',['users'=>$users]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSalaryRequest $request)
    {
        $validatedData= $request->validated();
        Salary::create($validatedData);
        return redirect()->back()->with('success','New Salary Posted For Worker');
    }

    /**
     * Display the specified resource.
     */
    public function show(Salary $salary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Salary $salary,$id)
    {
        $result=$salary->findOrFail($id);
        $user=$result->user;

        return view('salary.edit',['salary'=>$result,'user'=>$user]);
    }
    public function search(Request $request)
    {
        $query = $request->input('q', 'all');
        $searchDate = $request->input('searchdate','all');
        $salaryquery = Salary::query();

        if ($searchDate !== 'all') {
            $salaryquery->where('effective_date', $searchDate);
        }

        if ($query && $query !== 'all') {
            $users = collect($this->searchservice->searchUsers($request)); // Ensure $users is a collection
            $userIds = $users->pluck('id'); // Collect all user IDs
            $salaryquery->whereIn('user_id', $userIds);
        }

        $salaries = $salaryquery->latest()->paginate(6)->appends(['q' => $query, 'searchdate' => $searchDate]);

        return view('salary.index', ['salaries' => $salaries, 'query' => $query, 'searchdate' => $searchDate]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSalaryRequest $request, Salary $salary)
    {
        $validatedData= $request->validated();
        $salary->update($validatedData);

        return redirect()->back()->with('success','Salary Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Salary $salary)
    {
        //
    }
}
