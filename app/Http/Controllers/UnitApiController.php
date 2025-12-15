<?php

namespace App\Http\Controllers;

use App\Models\College;
use App\Models\Department;
use App\Models\Directory;
use Illuminate\Http\Request;

class UnitApiController extends Controller
{
    // 1. ሁሉንም ኮሌጆች ይመልሳል
    public function getColleges()
    {
        return College::all(['id', 'name_en']);
    }

    // 2. ሁሉንም ዳይሬክቶሬቶች ይመልሳል
    public function getDirectories()
    {
        return Directory::all(['id', 'name_en']);
    }

    // 3. በተመረጠው ኮሌጅ ስር ያሉ ዲፓርትመንቶችን ይመልሳል
    public function getDepartmentsByCollege($collegeId)
    {
        return Department::where('college_id', $collegeId)->get(['id', 'name_en']);
    }
}