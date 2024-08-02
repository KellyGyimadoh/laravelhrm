<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $departments=Department::all();
        return view('dashboard.index', ['user' => $user,'departments'=>$departments]);
    }

    public function create()
    {

        return view('dashboard.create');
    }
    public function getWorkerCount(Request $request)
    {
        $filter = $request->query('filter', 'all'); // Retrieve the 'filter' query parameter

        if ($filter === 'admins') {
            $counts = User::where('role', 'admin')->count();
            $type = 'Admins';
        } elseif ($filter === 'staff') {
            $counts = User::where('role', 'staff')->count();
            $type = 'Staff';
        } else {
            $counts = User::count();
            $type = 'All Workers';
        }

        return response()->json([
            'success' => true,
            'workerscount' => $counts,
            'workertype' => $type,
        ]);
    }
    public function getPresentWorkerCount(Request $request)
    {
        $filter = $request->query('filter', 'all'); // Retrieve the 'filter' query parameter

        $roles = ['admins' => 'admin', 'staff' => 'staff'];
        $statuses = [
            'presentcount' => 2,
            'absentcount' => 1,
            'latecount' => 4,
            'leavecount' => 3,
        ];

        // Determine role to filter by
        $role = $roles[$filter] ?? null;

        $counts = [];

        foreach ($statuses as $key => $status) {
            $query = User::query();

            if ($role) {
                $query->where('role', $role);
            }

            $counts[$key] = $query->whereHas('attendance', function ($query) use ($status) {
                $query->where('status', $status)->whereDate('date', today());
            })->count();
        }

        $type = $role ? ucfirst($filter) : 'All Workers';

        return response()->json([
            'success' => true,
            'presentcount' => $counts['presentcount'],
            'absentcount' => $counts['absentcount'],
            'latecount' => $counts['latecount'],
            'leavecount' => $counts['leavecount'],
            'workertype' => $type,
        ]);
    }

    public function getWorkerStatus(Request $request){
        $filter = $request->query('filter', 'all'); // Retrieve the 'filter' query parameter

        $roles = ['admins' => 'admin', 'staff' => 'staff'];
        $statuses = [
            'active' => 2,
            'suspended' => 1,
        ];

        // Determine role to filter by
        $role = $roles[$filter] ?? null;

        $counts = [];

        foreach ($statuses as $key => $status) {
            $query = User::query();

            if ($role) {
                $query->where('role', $role);
            }

            $counts[$key] =
                $query->where('status', $status)->count();
        }

        $type = $role ? ucfirst($filter) : 'All Workers';

        return response()->json([
            'success' => true,
            'activecount' => $counts['active'],
            'suspendedcount' => $counts['suspended'],
            'workertype' => $type,
        ]);
    }

    public function departmentTotal(Request $request){

        $departmentcount=Department::count();

        $usersheadcount=User::whereHas('headedDepartment')->count();


        return response()->json(
            ['success'=>true,
            'headcount'=>$usersheadcount,
            'departmentcount'=>$departmentcount
            ]
        );
    }

    public function departmentStatusCount(Request $request)
    {
        $filter = $request->input('filter', 'all');

        // Base queries for counts
        $activecountQuery = Department::query()->where('status', '2'); // Active departments
        $suspendedcountQuery = Department::query()->where('status', '1'); // Suspended departments
        $activeheadcountQuery = User::whereHas('headedDepartment')->where('status', '2'); // Active heads of department

        // Filter by department name if specified
        if ($filter !== 'all') {
            $activecountQuery->where('name', $filter);
            $suspendedcountQuery->where('name', $filter);
            $activeheadcountQuery->whereHas('headedDepartment', function ($query) use ($filter) {
                $query->where('name', $filter);
            });
        }

        // Get counts
        $activecount = $activecountQuery->count();
        $suspendedcount = $suspendedcountQuery->count();
        $activeheadcount = $activeheadcountQuery->count();

        // Get head of department details
        $departmentheads = User::whereHas('headedDepartment', function ($query) use ($filter) {
            if ($filter !== 'all') {
                $query->where('name', $filter);
            }
        })->get(['firstname', 'lastname', 'department_id']);

        // Prepare department head details
        $departmentheadDetails = [];
        foreach ($departmentheads as $head) {
            $departmentheadDetails[] = [
                'firstname' => $head->firstname,
                'lastname' => $head->lastname,
                'department_id' => $head->department_id,
            ];
        }

        return response()->json([
            'success' => true,
            'activeheadcount' => $activeheadcount,
            'suspendedcount' => $suspendedcount,
            'activecount' => $activecount,
            'departmenthead' => $departmentheadDetails,
            'departmenttype' => $filter
        ]);
    }

}
