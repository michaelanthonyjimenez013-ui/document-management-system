<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Patient;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::with(['patient', 'uploadedBy'])->active()->latest()->paginate(10);
        return view('documents.index', compact('documents'));
    }

    public function create()
    {
        $patients = Patient::active()->get();
        return view('documents.create', compact('patients'));
    }

    public function upload(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'assessment_id' => 'nullable|exists:assessments,id',
            'file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'category' => 'required|in:mswd_assessment_form,medical_certificate,birth_certificate,valid_id,barangay_certificate,hospital_bill,laboratory_result,prescription,referral_letter,other',
            'description' => 'nullable|string',
        ]);

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('documents', $fileName, 'public');

        $document = Document::create([
            'patient_id' => $validated['patient_id'],
            'assessment_id' => $validated['assessment_id'] ?? null,
            'uploaded_by' => Auth::id(),
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $filePath,
            'file_type' => $file->getClientOriginalExtension(),
            'file_size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'category' => $validated['category'],
            'description' => $validated['description'] ?? null,
        ]);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'upload',
            'module' => 'documents',
            'description' => "Uploaded document: {$document->file_name}",
            'patient_id' => $document->patient_id,
            'document_id' => $document->id,
            'new_values' => $document->toArray(),
        ]);

        return redirect()->route('documents.index')->with('success', 'Document uploaded successfully.');
    }

    public function show(Document $document)
    {
        return view('documents.show', compact('document'));
    }

    public function download(Document $document)
    {
        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'download',
            'module' => 'documents',
            'description' => "Downloaded document: {$document->file_name}",
            'patient_id' => $document->patient_id,
            'document_id' => $document->id,
        ]);

        return Storage::download($document->file_path, $document->file_name);
    }

    public function preview(Document $document)
    {
        $filePath = storage_path('app/public/' . $document->file_path);
        
        if (!file_exists($filePath)) {
            abort(404, 'File not found.');
        }

        return response()->file($filePath);
    }

    public function destroy(Document $document)
    {
        $fileName = $document->file_name;
        $patientId = $document->patient_id;
        
        // Delete file from storage
        Storage::delete($document->file_path);
        
        $document->delete();

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'delete',
            'module' => 'documents',
            'description' => "Deleted document: {$fileName}",
            'patient_id' => $patientId,
        ]);

        return redirect()->route('documents.index')->with('success', 'Document deleted successfully.');
    }

    public function patientDocuments(Patient $patient)
    {
        $documents = $patient->documents()->active()->latest()->get();
        return view('documents.patient', compact('patient', 'documents'));
    }

    public function bulkPrint(Request $request)
    {
        $validated = $request->validate([
            'documents' => 'required|array|min:1',
            'documents.*.id' => 'required|exists:documents,id',
            'documents.*.filePath' => 'required|string',
            'documents.*.fileName' => 'required|string',
        ]);

        $documents = [];
        foreach ($validated['documents'] as $docData) {
            $document = Document::find($docData['id']);
            if ($document) {
                $documents[] = $document;
            }
        }

        if (empty($documents)) {
            return response()->json(['error' => 'No valid documents found'], 404);
        }

        // Generate PDF with all selected documents
        $pdf = PDF::loadView('documents.bulk-print', compact('documents'));
        
        // Log the bulk print action
        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'bulk_print',
            'module' => 'documents',
            'description' => "Bulk printed " . count($documents) . " documents",
            'new_values' => ['document_ids' => array_column($documents, 'id')],
        ]);

        return $pdf->download('bulk_print_' . date('Y-m-d_H-i-s') . '.pdf');
    }
}
