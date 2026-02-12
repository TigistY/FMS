<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\College;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class CollegeController extends Controller
{
    /*
    public function __construct()
    {
        $this->middleware('permission:view colleges')->only('index', 'show');
        $this->middleware('permission:create colleges')->only('create', 'store');
        $this->middleware('permission:edit colleges')->only('edit', 'update');
        $this->middleware('permission:delete colleges')->only('destroy');
    }
    */
    public function index()
{
    $colleges = College::with('departments')->orderBy('name_en')->paginate(10);
    return view('colleges.index', compact('colleges'));
}

/*
    public function create()
    {
        return view('colleges.create');
    }
     public function edit(College $college)
    {
        return view('colleges.edit', compact('college'));
    }
*/
    public function store(Request $request)
    {
        $request->validate([
            'name_en' => 'required|string|max:255|unique:colleges',
            'name_am' => 'required|string|max:255|unique:colleges',
            'dean_name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:colleges',
        ]);

        College::create($request->all());
        return redirect()->route('colleges.index')
                         ->with('success', 'College registered successfully.');
    }


    public function update(Request $request, College $college)
    {
        $request->validate([
            'name_en' => 'required|string|max:255|unique:colleges,name_en,' . $college->id,
            'name_am' => 'required|string|max:255|unique:colleges,name_am,' . $college->id,
            'dean_name' => 'required|string|max:255,' . $college->id,
            'code' => 'required|string|max:10|unique:colleges,code,' . $college->id,
        ]);

        $college->update($request->all());
        return redirect()->route('colleges.index')
                         ->with('success', 'College updated successfully.');
    }

    public function destroy(College $college)
    {
        // ezh ga deparetment yalew college edaytefa
        if ($college->departments()->exists()) {
            return redirect()->route('colleges.index')
                             ->with('error', 'Cannot delete college: It has registered departments.');
        }

        $college->delete();
        return redirect()->route('colleges.index')
                         ->with('success', 'College deleted successfully.');
    }
}