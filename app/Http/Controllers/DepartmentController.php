<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Models\User;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::with('head')->latest()->paginate(4);
        return view('departments.index', ['departments' => $departments]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('departments.create');
    }
    public function search(Request $request)
    {
        $query = $request->input('q');
        $name = $request->input('name', 'all');
        $departmentQuery = Department::query();
        if ($name !== 'all') {
            $departmentQuery->where('name', $name);
        }
        if ($query) {
            $departmentQuery->where('name', 'LIKE', '%' . $query . '%');
        }

        $departments = $departmentQuery->paginate(4);

        return view('departments.index', ['departments' => $departments, 'query' => $query, 'name' => $name]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepartmentRequest $request, Department $department)
    {
        $validated= $request->validated();
         // Find the user who is the department head
         $userHead = User::where('firstname', $validated['departmenthead'])->first();

         if ($userHead) {
             // Assign the department head ID to the validated data array
             $validated['department_head_id'] = $userHead->id;
         }

         // Check if an image was uploaded
         if ($request->hasFile('image')) {
             // Store the new image
             $imagePath = $request->file('image')->store('deptLogos', 'public');
             $validated['image'] = $imagePath;
         }

         // Remove any fields that are not present in the database
         unset($validated['departmenthead']); // Remove 'departmenthead' if it's not a column

         // Update the department with the validated data
        if($department->createOrFirst($validated)){

         // Redirect back with a success message
         return redirect('/departments')->with('success', 'Department Added successfully.');
        }
        else{
         return redirect('/departments')->with('error', 'Department failed to Add');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        return view('departments.edit',['department'=>$department]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        // Validate and get the validated data from the request
        $validated = $request->validated();

        // Find the user who is the department head
        $userHead = User::where('firstname', $validated['departmenthead'])->first();

        if ($userHead) {
            // Assign the department head ID to the validated data array
            $validated['department_head_id'] = $userHead->id;
        }

        // Check if an image was uploaded
        if ($request->hasFile('image')) {
            // Store the new image
            $imagePath = $request->file('image')->store('deptLogos', 'public');
            $validated['image'] = $imagePath;
        }

        // Remove any fields that are not present in the database
        unset($validated['departmenthead']); // Remove 'departmenthead' if it's not a column

        // Update the department with the validated data
       if($department->update($validated)){

        // Redirect back with a success message
        return redirect('/departments/'.$department->id)->with('success', 'Department updated successfully.');
       }
       else{
        return redirect('/departments/'.$department->id)->with('error', 'Department failed to update');
       }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {

        $department->deleteOrFail();

        return redirect('/departments')->with('success','Department Successfully Removed');
    }

    public function suspend(Department $department){
        if($department->status===2){
            $department->update(['status'=>1]);
            return redirect('/departments/'.$department->id)->with('success','Department Suspended');
        }else{
            $department->update(['status'=>2]);
            return redirect('/departments/'.$department->id)->with('success','Department Activated');
        }


    }
}
