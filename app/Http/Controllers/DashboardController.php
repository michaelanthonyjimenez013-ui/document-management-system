<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Assessment;
use App\Models\Document;
use App\Models\User;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPatients = Patient::active()->count();
        $activeCases = Patient::active()->count();
        $pendingAssessments = Assessment::draft()->count();
        $completedAssessments = Assessment::completed()->count();
        $totalDocuments = Document::active()->count();
        
        $recentPatients = Patient::active()->latest()->take(5)->get();
        $recentAssessments = Assessment::latest()->take(5)->get();
        $recentDocuments = Document::active()->latest()->take(5)->get();
        $recentActivities = AuditLog::with('user')->latest()->take(5)->get();
        
        return view('dashboard.index', compact(
            'totalPatients',
            'activeCases',
            'pendingAssessments',
            'completedAssessments',
            'totalDocuments',
            'recentPatients',
            'recentAssessments',
            'recentDocuments',
            'recentActivities'
        ));
    }
}
