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
        // ስሞቹ በአማርኛም እንዲመጡ 'name_am' ጨምሬያለሁ (ካለህ)
        $colleges = College::select('id', 'name_en', 'name_am')->get();
        return response()->json($colleges);
    }

    // 2. ሁሉንም ዳይሬክቶሬቶች ይመልሳል
    public function getDirectories()
    {
        $directories = Directory::select('id', 'name_en', 'name_am')->get();
        return response()->json($directories);
    }

    // 3. በተመረጠው ኮሌጅ ስር ያሉ ዲፓርትመንቶችን ይመልሳል
    public function getDepartmentsByCollege($collegeId)
    {
        // መጀመሪያ ኮሌጁ መኖሩን ማረጋገጥ ጥሩ ነው
        $departments = Department::where('college_id', $collegeId)
            ->select('id', 'name_en', 'name_am')
            ->get();

        // ዳታው ባዶ ቢሆንም እንኳን እንደ JSON array መመለስ አለበት
        return response()->json($departments);
    }
}