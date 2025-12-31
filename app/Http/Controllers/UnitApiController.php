<?php

namespace App\Http\Controllers;

use App\Models\College;
use App\Models\Department;
use App\Models\Directory;
use Illuminate\Http\Request;

class UnitApiController extends Controller
{
    public function getColleges()
    {
        $colleges = College::select('id', 'name_en', 'name_am')->get();
        return response()->json($colleges);
    }

    public function getDirectories()
    {
        $directories = Directory::select('id', 'name_en', 'name_am')->get();
        return response()->json($directories);
    }

    public function getDepartmentsByCollege($collegeId)
    {
        $departments = Department::where('college_id', $collegeId)
            ->select('id', 'name_en', 'name_am')
            ->get();

        return response()->json($departments);
    }
}