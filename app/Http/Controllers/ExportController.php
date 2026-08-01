<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\Patient;
use App\Models\Document;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;
use Excel;
use App\Exports\PatientsExport;
use App\Exports\AssessmentsExport;

class ExportController extends Controller
{
    public function exportAssessment(Assessment $assessment)
    {
        $assessment->load(['patient', 'createdBy']);
        
        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'export',
            'module' => 'assessments',
            'description' => "Exported assessment ID: {$assessment->id} to PDF",
            'patient_id' => $assessment->patient_id,
            'assessment_id' => $assessment->id,
        ]);

        $pdf = PDF::loadView('exports.assessment', compact('assessment'));
        return $pdf->download("assessment_{$assessment->id}.pdf");
    }

    public function exportPatient(Patient $patient)
    {
        $patient->load(['assessments', 'documents']);
        
        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'export',
            'module' => 'patients',
            'description' => "Exported patient: {$patient->full_name} to Excel",
            'patient_id' => $patient->id,
        ]);

        return Excel::download(new PatientsExport($patient->id), "patient_{$patient->id}.xlsx");
    }

    public function exportDocuments(Request $request)
    {
        $documentIds = $request->input('document_ids', []);
        
        if (empty($documentIds)) {
            return back()->with('error', 'No documents selected for export.');
        }

        $documents = Document::whereIn('id', $documentIds)->get();
        
        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'export',
            'module' => 'documents',
            'description' => "Exported " . count($documents) . " documents",
        ]);

        // For prototype, return a simple response
        // In production, implement zip file creation
        return back()->with('success', count($documents) . ' documents prepared for export.');
    }
}
