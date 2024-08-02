<?php

namespace App\Http\Controllers;

use App\Models\UserLeave;
use App\Http\Requests\StoreUserLeaveRequest;
use App\Http\Requests\UpdateUserLeaveRequest;
use App\Models\User;
use App\Services\SearchService;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserLeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $searchservice;
    public function __construct(SearchService $searchService)
    {
        $this->searchservice = $searchService;
    }
    public function index()
    {

        $leave = UserLeave::with('user')->latest()->paginate(5);

        return view('leave.index', ['leaves' => $leave]);
    }

    public function search(Request $request)
    {
        $query = $request->input('q', 'all');
        $status = $request->input('status', 'all');
        $leavequery = UserLeave::query();


        if ($status !== 'all') {
            $leavequery->where('status', $status);
        }

        if ($query && $query!=='all') {
            $users = $this->searchservice->searchUsers($request);
            foreach ($users as $user) {
                $userid = $user->id;
                $leavequery->where('user_id', $userid);
            }
        }

        $leaves = $leavequery->latest()->paginate(6)->appends(['q'=>$query,'status'=>$status]);


        return view('leave.index', ['leaves' => $leaves,'query'=>$query,'status'=>$status]);
    }

    public function searchWorker(Request $request,User $user)
    {
        $query = $request->input('q', );
        $status = $request->input('status', 'all');
        $leavequery = UserLeave::query()->where('user_id',$user->id);


        if ($status !== 'all') {
            $leavequery->where('status',$status);

        }



        $leave = $leavequery->latest()->paginate(6);



        return view('leave.show', ['leave' => $leave,'worker'=>$user,'query'=>$status]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(User $authUser)
    {
        $worker = Auth::user();
        return view('leave.create', ['worker' => $worker]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserLeaveRequest $request)
    {
        $validated = $request->validated();

        // Merge the user_id with the validated data
        $data = array_merge($validated, ['user_id' => Auth::id()]);

       // $query = UserLeave::create($data);

        // Filter out the _token and _method fields
   // $data = $request->except(['_token', '_method']);
    //$querydata = array_merge($data, ['user_id' => Auth::id()]);


      // $query = UserLeave::create($querydata);
       $query = UserLeave::create($data);


       /*  if ($query) {
            return response()->json([
                'success' => true,
                'message' => 'Leave request posted successfully',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Leave request failed to process!',
            ]);
        } */

        if ($query) {
            return redirect()->back()->with('success', 'Leave Request done');
        } else {
            return redirect()->back()->with('error', 'Leave Request Failed');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(UserLeave $userLeave,User $user)
    {
        $userid= $user->id;
        $leave=$userLeave->with('user')->where('user_id',$userid)->paginate(5);

        return view('leave.show',['leave'=>$leave,'worker'=>$user]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $leave = UserLeave::findOrFail($id);
        $user = $leave->user; // Assuming there is a relation defined in UserLeave model to fetch the user

        return view('leave.edit', ['leave' => $leave, 'user' => $user]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserLeaveRequest $request, $id)
    {
        $validatedData = $request->validated();

        $leave = UserLeave::findOrFail($id);
       if($leave->update($validatedData)){

        return redirect()->back()->with('success', 'Leave request updated successfully.');
       }else{
        return redirect()->back()->with('success', 'Leave request Failed to Update');
       }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserLeave $userLeave)
    {
        //
    }
}
