<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\College;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manage colleges'); // Departments የሚመዘገበው በ colleges ስር ስለሆነ ተመሳሳይ permission እንስጠው
    }

    public function index()
    {
        // with('college') በመጠቀም የኮሌጁን ስም መጫን
        $departments = Department::with('college')->orderBy('name')->paginate(15);
        return view('admin.departments.index', compact('departments'));
    }

    public function create()
    {
        $colleges = College::all(); // ኮሌጆችን ለምርጫ ማምጣት
        return view('admin.departments.create', compact('colleges'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'college_id' => 'required|exists:colleges,id',
            'name_en' => 'required|string|max:255|unique:departments',
            'name_am' => 'required|string|max:255|unique:departments',
            'head_name' => 'nullable|string|max:255',
        ]);

        Department::create($request->all());
        return redirect()->route('admin.departments.index')
                         ->with('success', 'Department registered successfully.');
    }

    public function edit(Department $department)
    {
        $colleges = College::all();
        return view('admin.departments.edit', compact('department', 'colleges'));
    }

    public function update(Request $request, Department $department)
    {
        $request->validate([
            'college_id' => 'required|exists:colleges,id',
            'name_en' => 'required|string|max:255|unique:departments,name,' . $department->id,
            'name_am' => 'required|string|max:255|unique:departments,name,' . $department->id,
            'head_name' => 'nullable|string|max:255',
        ]);

        $department->update($request->all());
        return redirect()->route('admin.departments.index')
                         ->with('success', 'Department updated successfully.');
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('admin.departments.index')
                         ->with('success', 'Department deleted successfully.');
    }
}