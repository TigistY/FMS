<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\College;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role; // Spatie Permissionን መጠቀምዎን ያረጋግጡ

class CollegeController extends Controller
{
    public function __construct()
    {
        // ኮሌጅን የማስተዳደር መብት ያለው 'admin' ወይም 'super-admin' ብቻ መሆኑን ለማረጋገጥ
        $this->middleware('permission:manage colleges'); 
    }

    public function index()
    {
        $colleges = College::orderBy('name')->paginate(10);
        return view('admin.colleges.index', compact('colleges'));
    }

    public function create()
    {
        return view('admin.colleges.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_en' => 'required|string|max:255|unique:colleges',
            'name_am' => 'required|string|max:255|unique:colleges',
            'code' => 'required|string|max:10|unique:colleges',
        ]);

        College::create($request->all());
        return redirect()->route('admin.colleges.index')
                         ->with('success', 'College registered successfully.');
    }

    public function edit(College $college)
    {
        return view('admin.colleges.edit', compact('college'));
    }

    public function update(Request $request, College $college)
    {
        $request->validate([
            'name_en' => 'required|string|max:255|unique:colleges,name,' . $college->id,
            'name_am' => 'required|string|max:255|unique:colleges,name,' . $college->id,
            'code' => 'required|string|max:10|unique:colleges,code,' . $college->id,
        ]);

        $college->update($request->all());
        return redirect()->route('admin.colleges.index')
                         ->with('success', 'College updated successfully.');
    }

    public function destroy(College $college)
    {
        $college->delete();
        return redirect()->route('admin.colleges.index')
                         ->with('success', 'College deleted successfully.');
    }
}