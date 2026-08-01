<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Document;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PatientsImport;

class ImportController extends Controller
{
    public function index()
    {
        return view('import.index');
    }

    public function importPatients(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        try {
            Excel::import(new PatientsImport, $request->file('file'));

            AuditLog::create([
                'user_id' => Auth::id(),
                'action' => 'import',
                'module' => 'patients',
                'description' => 'Imported patients from Excel file',
            ]);

            return back()->with('success', 'Patients imported successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error importing patients: ' . $e->getMessage());
        }
    }

    public function importDocuments(Request $request)
    {
        $request->validate([
            'files' => 'required|array',
            'files.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'patient_id' => 'required|exists:patients,id',
            'category' => 'required|in:mswd_assessment_form,medical_certificate,birth_certificate,valid_id,barangay_certificate,hospital_bill,laboratory_result,prescription,referral_letter,other',
        ]);

        $uploadedCount = 0;
        $duplicateCount = 0;

        foreach ($request->file('files') as $file) {
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('documents', $fileName, 'public');

            // Check for duplicate
            $existing = Document::where('file_name', $file->getClientOriginalName())
                ->where('patient_id', $request->patient_id)
                ->first();

            if ($existing) {
                $duplicateCount++;
                Storage::delete($filePath);
                continue;
            }

            Document::create([
                'patient_id' => $request->patient_id,
                'uploaded_by' => Auth::id(),
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $filePath,
                'file_type' => $file->getClientOriginalExtension(),
                'file_size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'category' => $request->category,
            ]);

            $uploadedCount++;
        }

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'import',
            'module' => 'documents',
            'description' => "Imported {$uploadedCount} documents, skipped {$duplicateCount} duplicates",
        ]);

        return back()->with('success', "Imported {$uploadedCount} documents successfully. Skipped {$duplicateCount} duplicates.");
    }
}
