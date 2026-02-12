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
    $colleges = College::with('departments')->get();
    $directories = Directory::all();

    $collegeData = $colleges->map(function($college) {
        return [
            'id' => $college->id,
            'name' => $college->name_en,
            'complaints_count' => Complaint::where('recipient_type', 'College')->where('recipient_id', $college->id)->count(),
            'feedback_count' => Feedback::where('recipient_type', 'College')->where('recipient_id', $college->id)->count(),
        
            'sentiment' => [
                'Positive' => Feedback::where('recipient_type', 'College')->where('recipient_id', $college->id)->where('feedback_type', 'Positive')->count(),
                'Neutral'  => Feedback::where('recipient_type', 'College')->where('recipient_id', $college->id)->where('feedback_type', 'Neutral')->count(),
                'Negative' => Feedback::where('recipient_type', 'College')->where('recipient_id', $college->id)->where('feedback_type', 'Negative')->count(),
            ],
            'departments' => $college->departments->map(function($dept) {
                return [
                    'id' => $dept->id,
                    'name' => $dept->name_en,
                    'complaints_count' => Complaint::where('recipient_type', 'Department')->where('recipient_id', $dept->id)->count(),
                    'feedback_count' => Feedback::where('recipient_type', 'Department')->where('recipient_id', $dept->id)->count(),
            
                    'sentiment' => [
                        'Positive' => Feedback::where('recipient_type', 'Department')->where('recipient_id', $dept->id)->where('feedback_type', 'Positive')->count(),
                        'Neutral'  => Feedback::where('recipient_type', 'Department')->where('recipient_id', $dept->id)->where('feedback_type', 'Neutral')->count(),
                        'Negative' => Feedback::where('recipient_type', 'Department')->where('recipient_id', $dept->id)->where('feedback_type', 'Negative')->count(),
                    ],
                ];
            })
        ];
    });

    $directoryData = $directories->map(function($dir) {
        return [
            'id' => $dir->id,
            'name' => $dir->name_en,
            'complaints_count' => Complaint::where('recipient_type', 'Directory')->where('recipient_id', $dir->id)->count(),
            'feedback_count' => Feedback::where('recipient_type', 'Directory')->where('recipient_id', $dir->id)->count(),

            'sentiment' => [
                'Positive' => Feedback::where('recipient_type', 'Directory')->where('recipient_id', $dir->id)->where('feedback_type', 'Positive')->count(),
                'Neutral'  => Feedback::where('recipient_type', 'Directory')->where('recipient_id', $dir->id)->where('feedback_type', 'Neutral')->count(),
                'Negative' => Feedback::where('recipient_type', 'Directory')->where('recipient_id', $dir->id)->where('feedback_type', 'Negative')->count(),
            ],
        ];
    });

    return view('reports.units', compact('collegeData', 'directoryData'));
}
}