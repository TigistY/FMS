<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Directory;
use Illuminate\Http\Request;

class DirectoryController extends Controller
{
    public function index()
    {
        $directories = Directory::orderBy('name_en')->paginate(10);
        return view('directories.index', compact('directories'));
    }

    /* 
    public function create()
    {
        return view('directories.create');
    }

    public function edit(Directory $directory)
    {
        return view('directories.edit', compact('directory'));
    }
    */

    public function store(Request $request)
    {
        $request->validate([
            'name_en'      => 'required|string|max:255|unique:directories',
            'name_am'      => 'required|string|max:255|unique:directories',
            'code'         => 'required|string|max:10|unique:directories',
            'manager_name' => 'nullable|string|max:255',
            'description'  => 'nullable|string',
        ]);

        Directory::create($request->all());

        return redirect()->route('directories.index')
                         ->with('success', 'Directory registered successfully.');
    }

    public function update(Request $request, Directory $directory)
    {
        $request->validate([
            'name_en'      => 'required|string|max:255|unique:directories,name_en,' . $directory->id,
            'name_am'      => 'required|string|max:255|unique:directories,name_am,' . $directory->id,
            'code'         => 'required|string|max:10|unique:directories,code,' . $directory->id,
            'manager_name' => 'nullable|string|max:255',
            'description'  => 'nullable|string',
        ]);

        $directory->update($request->all());

        return redirect()->route('directories.index')
                         ->with('success', 'Directory updated successfully.');
    }

    public function destroy(Directory $directory)
    {
        $directory->delete();
        return redirect()->route('directories.index')
                         ->with('success', 'Directory deleted successfully.');
    }

    /*public function show(Directory $directory)
    {
        return response()->json($directory); 
    }*/
}