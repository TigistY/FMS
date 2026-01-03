<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\College;
use App\Models\Department;
use App\Models\Directory;
use App\Models\Complaint;
use App\Models\Feedback;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function unitStats()
    {
        // ሁሉንም Colleges ከነ Department-ታቸው መጫን
        $colleges = College::with('departments')->get();
        $directories = Directory::all();

        // ለእያንዳንዱ College ስታቲስቲክስ ማዘጋጀት
        $collegeData = $colleges->map(function($college) {
            return [
                'id' => $college->id,
                'name' => $college->name_en,
                'complaints_count' => Complaint::where('recipient_type', 'College')->where('recipient_id', $college->id)->count(),
                'feedback_count' => Feedback::where('recipient_type', 'College')->where('recipient_id', $college->id)->count(),
                'departments' => $college->departments->map(function($dept) {
                    return [
                        'id' => $dept->id,
                        'name' => $dept->name_en,
                        'complaints_count' => Complaint::where('recipient_type', 'Department')->where('recipient_id', $dept->id)->count(),
                        'feedback_count' => Feedback::where('recipient_type', 'Department')->where('recipient_id', $dept->id)->count(),
                    ];
                })
            ];
        });

        // ለ Directories
        $directoryData = $directories->map(function($dir) {
            return [
                'id' => $dir->id,
                'name' => $dir->name_en,
                'complaints_count' => Complaint::where('recipient_type', 'Directory')->where('recipient_id', $dir->id)->count(),
                'feedback_count' => Feedback::where('recipient_type', 'Directory')->where('recipient_id', $dir->id)->count(),
            ];
        });

        return view('reports.units', compact('collegeData', 'directoryData'));
    }
}