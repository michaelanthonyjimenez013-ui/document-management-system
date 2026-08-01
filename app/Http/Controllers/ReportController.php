<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Assessment;
use App\Models\Document;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function patientsReport()
    {
        $patients = Patient::active()->latest()->get();
        return view('reports.patients', compact('patients'));
    }

    public function assessmentsReport()
    {
        $assessments = Assessment::with('patient')->latest()->get();
        return view('reports.assessments', compact('assessments'));
    }

    public function documentsReport()
    {
        $documents = Document::with(['patient', 'uploadedBy'])->active()->latest()->get();
        return view('reports.documents', compact('documents'));
    }
}
