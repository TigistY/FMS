<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Directory;
use Illuminate\Http\Request;

class DirectoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manage directories');
    }

    public function index()
    {
        $directories = Directory::orderBy('name')->paginate(10);
        return view('admin.directories.index', compact('directories'));
    }

    public function create()
    {
        return view('admin.directories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_en' => 'required|string|max:255|unique:directories',
            'name_am' => 'required|string|max:255|unique:directories',
            'code' => 'required|string|max:10|unique:directories',
        ]);

        Directory::create($request->all());
        return redirect()->route('admin.directories.index')
                         ->with('success', 'Directory registered successfully.');
    }

    public function edit(Directory $directory)
    {
        return view('admin.directories.edit', compact('directory'));
    }

    public function update(Request $request, Directory $directory)
    {
        $request->validate([
            'name_en' => 'required|string|max:255|unique:directories,name,' . $directory->id,
            'name_am' => 'required|string|max:255|unique:directories,name,' . $directory->id,
            'code' => 'required|string|max:10|unique:directories,code,' . $directory->id,
        ]);

        $directory->update($request->all());
        return redirect()->route('admin.directories.index')
                         ->with('success', 'Directory updated successfully.');
    }

    public function destroy(Directory $directory)
    {
        $directory->delete();
        return redirect()->route('admin.directories.index')
                         ->with('success', 'Directory deleted successfully.');
    }
}