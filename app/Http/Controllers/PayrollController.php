<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Http\Requests\StorePayrollRequest;
use App\Http\Requests\UpdatePayrollRequest;
use App\Models\Salary;
use App\Models\User;
use App\Services\SearchService;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    protected $searchservice;
    public function __construct(SearchService $searchService){
        $this->searchservice=$searchService;
    }
    public function index()
    {
        $payrolls=Payroll::with('user')->latest()->paginate(6);
         return view('payroll.index',['payrolls'=>$payrolls]);
    }


    public function search(Request $request)
    {
        $query = $request->input('q', 'all');
        $status = $request->input('status', 'all');
        $payrollquery = Payroll::query();

        if ($status !== 'all') {
            $payrollquery->where('status', $status);
        }

        if ($query && $query !== 'all') {
            $users = collect($this->searchservice->searchUsers($request)); // Ensure $users is a collection
            $userIds = $users->pluck('id'); // Collect all user IDs
            $payrollquery->whereIn('user_id', $userIds);
        }

        $payrolls = $payrollquery->latest()->paginate(6)->appends(['q' => $query, 'status' => $status]);

        return view('payroll.index', ['payrolls' => $payrolls, 'query' => $query, 'status' => $status]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users=User::with('salaries')->get();
        return view('payroll.create',['users'=>$users]);
    }

    public function payment()
    {
        $payrolls = Payroll::with(['user.department', 'user.salaries' => function($query) {
            $query->latest('effective_date');
        }])->paginate(10);

        // Attach the latest salary to each payroll
        foreach ($payrolls as $payroll) {
            $payroll->latest_salary = $payroll->user->salaries->first()->amount ?? 'No Salary Set';
        }

        return view('payroll.payment', ['payrolls' => $payrolls]);
    }

    public function processPayments(Request $request)
    {
        $payrollIds = $request->input('payroll_ids', []);

        if (!empty($payrollIds)) {
            Payroll::whereIn('id', $payrollIds)->update(['status' => 2]); // Mark as paid
        }

        return redirect()->back()->with('success', 'Payments processed successfully.');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePayrollRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
     $userpayroll=Payroll::findOrFail($id);
     $worker=$userpayroll->user;
        return view('payroll.edit',['payroll'=>$userpayroll,'user'=>$worker]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePayrollRequest $request,$id)
    {
        $validatedData= $request->validated();
        $userpayroll=Payroll::findOrFail($id);
        if($userpayroll->status=='2'){
            return redirect()->back()->with('success','User Already Paid');
        }

        if($userpayroll->update($validatedData)){
            return redirect()->back()->with('success','Payroll Info Updated Successfully');
        }else{
            return redirect()->back()->with('success','Failed to Process. Try again!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payroll $payroll)
    {
        //
    }
}
