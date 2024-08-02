<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;

class SearchService
{
    /**
     * Search for users based on the request parameters.
     */
    public function searchUsers(Request $request)
    {
        // Build the base query with department and today's attendance records
        $workersQuery = User::with(['department', 'attendance' => function ($query) {
            $query->whereDate('date', today()); // Filter attendance records for today
        }]);

        // Optionally filter by role
        $role = $request->input('role', 'all');
        if ($role !== 'all') {
            $workersQuery->where('role', $role);
        }

        // Optionally filter by search query
        $query = $request->input('q');
        if ($query && $query!=='all') {
            $workersQuery->where('firstname', 'LIKE', '%' . $query . '%');
        }

        // Return paginated results
        return $workersQuery->paginate(4)->appends(['q'=>$query,'role'=>$role]);
    }
    public function searchAdmin(Request $request)
    {
        $query = $request->input('q');

        // Query to get only admin members
        $workersQuery = User::with(['department', 'attendance' => function ($query) {
            $query->whereDate('date', today()); // Filter attendance records for today
        }])->where('role', 'admin');

        // Apply search query filtering if specified
        if ($query) {
            $workersQuery->where('firstname', 'LIKE', '%' . $query . '%')
                         ->orWhere('lastname', 'LIKE', '%' . $query . '%');
        }

        // Return paginated results
        return $workersQuery->paginate(4)->appends(['q'=>$query]);


    }
    public function searchStaff(Request $request)
    {
        $query = $request->input('q');

        // Query to get only staff members
        $workersQuery = User::with(['department', 'attendance' => function ($query) {
            $query->whereDate('date', today()); // Filter attendance records for today
        }])->where('role', 'staff');

        // Apply search query filtering if specified
        if ($query) {
            $workersQuery->where('firstname', 'LIKE', '%' . $query . '%')
                         ->orWhere('lastname', 'LIKE', '%' . $query . '%');
        }

        // Return paginated results
         return $workersQuery->paginate(4)->appends(['q'=>$query,'role'=>'staff']);;


    }

}
