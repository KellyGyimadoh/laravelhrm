<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Http\Requests\StoreAttendanceRequest;
use App\Http\Requests\UpdateAttendanceRequest;
use App\Models\Department;
use App\Models\User;
use App\Services\SearchService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    public function index(Request $request)
    {
        // Use the search service to get workers with attendance for today
        $workers = $this->searchService->searchUsers($request);

        // Load today's attendance for each worker
        $today = today()->toDateString();
        foreach ($workers as $worker) {
            $worker->attendance_for_today = $worker->attendance->firstWhere('date', $today);
        }
        $departments = Department::all();
        return view('attendance.index', ['workers' => $workers, 'departments' => $departments]);
    }
    public function staff(Request $request)
    {
        $workers = $this->searchService->searchStaff($request);

        $today = today()->toDateString();
        foreach ($workers as $worker) {
            $worker->attendance_for_today = $worker->attendance->firstWhere('date', $today);
        }

        $departments = Department::all();

        return view('attendance.staff.index', [
            'workers' => $workers,
            'departments' => $departments,
            'query' => $request->input('q', ''),
            'selectedDepartment' => $request->input('department', 'all'),
        ]);
    }

    public function admin(Request $request)
    {
        $workers = $this->searchService->searchAdmin($request);

        $today = today()->toDateString();
        foreach ($workers as $worker) {
            $worker->attendance_for_today = $worker->attendance->firstWhere('date', $today);
        }

        $departments = Department::all();

        return view('attendance.admin.index', [
            'workers' => $workers,
            'departments' => $departments,
            'query' => $request->input('q', ''),
            'selectedDepartment' => $request->input('department', 'all'),
        ]);
    }

    /* Show the form for creating a new resource.
     */
    public function search(Request $request)
    {
        $query = $request->input('q');
        $departmentName = $request->input('department');

        // Build the query for departments
        $departmentQuery = Department::query();
        if ($query) {
            $departmentQuery->where('name', 'LIKE', '%' . $query . '%');
        }

        // Fetch departments if needed for the dropdown
        $departments = $departmentQuery->get();

        // Query workers
        $workersQuery = User::query()->with('attendance', 'department');

        // Apply department filtering
        if ($departmentName && $departmentName !== 'all') {
            $workersQuery->whereHas('department', function ($query) use ($departmentName) {
                $query->where('name', $departmentName);
            });
        }

        // Apply search query filtering
        if ($query) {
            $workersQuery->where('firstname', 'LIKE', '%' . $query . '%')
                ->orWhere('lastname', 'LIKE', '%' . $query . '%');
        }

        // Paginate the results
        $workers = $workersQuery->paginate(6)->appends(['q'=>$query,'department'=>$departmentName]);

        // Load today's attendance for each worker
        $today = today()->toDateString();
        foreach ($workers as $worker) {
            $worker->attendance_for_today = $worker->attendance->firstWhere('date', $today);
        }

        return view('attendance.index', [
            'workers' => $workers,
            'query' => $query,
            'departments' => $departments,
            'selectedDepartment' => $departmentName
        ]);
    }
    public function searchforStaff(Request $request)
    {
        $query = $request->input('q');
        $departmentName = $request->input('department');

        // Build the query for departments
        $departmentQuery = Department::query();
        if ($query) {
            $departmentQuery->where('name', 'LIKE', '%' . $query . '%');
        }

        // Fetch departments if needed for the dropdown
        $departments = $departmentQuery->get();

        // Query workers
        $workersQuery = User::query()->with('attendance', 'department');

        // Apply department filtering
        if ($departmentName && $departmentName !== 'all') {
            $workersQuery->whereHas("department", function ($query) use ($departmentName) {
                $query->where('name', $departmentName);
            });
        }

        // Apply search query filtering
        if ($query) {
            $workersQuery->where('firstname', 'LIKE', '%' . $query . '%')
                ->orWhere('lastname', 'LIKE', '%' . $query . '%');
        }

        // Paginate the results
        $workers = $workersQuery->paginate(6)->appends(['q'=>$query,'department'=>$departmentName]);

        // Load today's attendance for each worker
        $today = today()->toDateString();
        foreach ($workers as $worker) {
            $worker->attendance_for_today = $worker->attendance->firstWhere('date', $today);
        }

        return view('attendance.staff.index', [
            'workers' => $workers,
            'query' => $query,
            'departments' => $departments,
            'selectedDepartment' => $departmentName
        ]);
    }
    public function searchforAdmin(Request $request)
    {
        $query = $request->input('q');
        $departmentName = $request->input('department');

        // Build the query for departments
        $departmentQuery = Department::query();
        if ($query) {
            $departmentQuery->where('name', 'LIKE', '%' . $query . '%');
        }

        // Fetch departments if needed for the dropdown
        $departments = $departmentQuery->get();

        // Query workers
        $workersQuery = User::query()->with('attendance', 'department');

        // Apply department filtering
        if ($departmentName && $departmentName !== 'all') {
            $workersQuery->whereHas('department', function ($query) use ($departmentName) {
                $query->where('name', $departmentName);
            });
        }

        // Apply search query filtering
        if ($query) {
            $workersQuery->where('firstname', 'LIKE', '%' . $query . '%')
                ->orWhere('lastname', 'LIKE', '%' . $query . '%');
        }

        // Paginate the results
        $workers = $workersQuery->paginate(6)->appends(['q'=>$query,'department'=>$departmentName]);;;

        // Load today's attendance for each worker
        $today = today()->toDateString();
        foreach ($workers as $worker) {
            $worker->attendance_for_today = $worker->attendance->firstWhere('date', $today);
        }

        return view('attendance.admin.index', [
            'workers' => $workers,
            'query' => $query,
            'departments' => $departments,
            'selectedDepartment' => $departmentName
        ]);
    }
    public function searchHistory(Request $request)
    {
        $query = $request->input('q');
        $departmentName = $request->input('department');
        $searchDate = $request->input('datesearch'); // Use the search date

        // Build the query for departments
        $departmentQuery = Department::query();
        if ($query) {
            $departmentQuery->where('name', 'LIKE', '%' . $query . '%');
        }

        // Fetch departments if needed for the dropdown
        $departments = $departmentQuery->get();

        // Query workers with their attendance for a specific date
        $workersQuery = User::query()->with('attendance', 'department');

        // Apply department filtering
        if ($departmentName && $departmentName !== 'all') {
            $workersQuery->whereHas('department', function ($query) use ($departmentName) {
                $query->where('name', $departmentName);
            });
        }

        // Apply search query filtering
        if ($query) {
            $workersQuery->where('firstname', 'LIKE', '%' . $query . '%')
                ->orWhere('lastname', 'LIKE', '%' . $query . '%');
        }

        // Apply date filtering
        if ($searchDate) {
            $workersQuery->whereHas('attendance', function ($query) use ($searchDate) {
                $query->whereDate('date', $searchDate);
            });
        }

        // Paginate the results
        $workers = $workersQuery->paginate(6)->appends(['q'=>$query,'department'=>$departmentName,'datesearch'=>$searchDate]);;;

        // Load attendance for the specific date for each worker
        foreach ($workers as $worker) {
            $worker->attendance_for_date = $worker->attendance->firstWhere('date', $searchDate);
        }

        return view('attendance.history', [
            'workers' => $workers,
            'query' => $query,
            'departments' => $departments,
            'selectedDepartment' => $departmentName,
            'selectedDate' => $searchDate
        ]);
    }

    public function history(Request $request)
    {
        // Use the search service to get workers with attendance for today
        $workers = $this->searchService->searchUsers($request);

        // Load today's attendance for each worker
        $today = today()->toDateString();
        foreach ($workers as $worker) {
            $worker->attendance_for_today = $worker->attendance->firstWhere('date', $today);
        }
        $departments = Department::all();
        return view('attendance.history', ['workers' => $workers, 'departments' => $departments]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAttendanceRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function create(Attendance $attendance, User $user)
    {
        $worker = Auth::user();
        return view('attendance.create', ['worker' => $worker]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function checkin(User $user, Request $request)
    {
        $userId = $user->id;
        $today = today()->toDateString();

        // Determine the lateness threshold (e.g., 9:00 AM)
        $latenessThreshold = Carbon::createFromTime(9, 0, 0); // 9:00 AM

        // Current check-in time
        $checkInTime = Carbon::now();

        // Check for lateness
        $isLate = $checkInTime->greaterThan($latenessThreshold);

        // Update or create attendance record

        Attendance::updateOrCreate(
            [
                'user_id' => $userId,
                'date' => $today
            ],
            [
                'check_in_time' => $checkInTime,
                'status' => $isLate ? 4 : 2 // Assuming 4 for late, 2 for present
            ]
        );

        $message = $isLate ? 'Check-in successful, but you are late.' : 'Check-in successful!';

        return redirect()->back()->with('success', $message);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAttendanceRequest $request, Attendance $attendance)
    {
        //
    }

    public function show(Attendance $attendance,User $user){
        $worker=$attendance->where('user_id',$user->id)->paginate(6);
        return view('attendance.view');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        //
    }
}
