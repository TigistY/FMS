<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\College;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /*
    public function __construct()
{
    $this->middleware('permission:view departments')->only('index', 'show');
    $this->middleware('permission:create departments')->only('create', 'store');
    $this->middleware('permission:edit departments')->only('edit', 'update');
    $this->middleware('permission:delete departments')->only('destroy');
}
*/

/*commint b/c use modal
    public function index()
    {
        $departments = Department::with('college')->orderBy('name_en')->paginate(15);
        return view('departments.index', compact('departments'));
    }

    public function create()
    {
        $colleges = College::all(); 
        return view('departments.create', compact('colleges'));
    }

     public function edit(Department $department)
    {
        $colleges = College::all();
        return view('departments.edit', compact('department', 'colleges'));
    }
        public function show(Department $department)
{
    $department->load('college');
    return view('departments.show', compact('department'));
}
    */

    public function store(Request $request)
    {
        $request->validate([
            'college_id' => 'required|exists:colleges,id',
            'name_en' => 'required|string|max:255|unique:departments',
            'name_am' => 'required|string|max:255|unique:departments',
            
        ]);

        Department::create($request->all());
        return redirect()->back()->with('success', 'Department registered successfully.');
    }


    public function update(Request $request, Department $department)
    {
        $request->validate([
            'college_id' => 'required|exists:colleges,id',
            'name_en' => 'required|string|max:255|unique:departments,name_en,' . $department->id,
            'name_am' => 'required|string|max:255|unique:departments,name_am,' . $department->id,

        ]);

        $department->update($request->all());
        return redirect()->back()->with('success', 'Department updated successfully.');
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->back()->with('success', 'Department deleted successfully.');
    }
    
}