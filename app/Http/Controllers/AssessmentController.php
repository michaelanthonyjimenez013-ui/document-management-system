<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\Patient;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssessmentController extends Controller
{
    public function index()
    {
        $assessments = Assessment::with('patient')->latest()->paginate(10);
        return view('assessments.index', compact('assessments'));
    }

    public function create()
    {
        $patients = Patient::active()->get();
        return view('assessments.create', compact('patients'));
    }

    public function createForPatient(Patient $patient)
    {
        return view('assessments.create', compact('patient'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'father_name' => 'nullable|string|max:255',
            'father_occupation' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'mother_occupation' => 'nullable|string|max:255',
            'family_members' => 'nullable|integer',
            'siblings' => 'nullable|integer',
            'birth_order' => 'nullable|integer',
            'family_composition' => 'nullable|string',
            'family_income_source' => 'nullable|string',
            'monthly_income' => 'nullable|numeric',
            'classification' => 'nullable|in:a,b,c,d',
            'classification_remarks' => 'nullable|string',
            'medical_history' => 'nullable|string',
            'current_diagnosis' => 'nullable|string',
            'hospital_name' => 'nullable|string|max:255',
            'admission_date' => 'nullable|date',
            'discharge_date' => 'nullable|date',
            'food_expenses' => 'nullable|numeric',
            'rent_expenses' => 'nullable|numeric',
            'utilities_expenses' => 'nullable|numeric',
            'transportation_expenses' => 'nullable|numeric',
            'medical_expenses' => 'nullable|numeric',
            'education_expenses' => 'nullable|numeric',
            'other_expenses' => 'nullable|numeric',
            'presenting_problems' => 'nullable|string',
            'client_concerns' => 'nullable|string',
            'housing_type' => 'nullable|in:owned,rented,shared,informal_settler',
            'housing_condition' => 'nullable|string',
            'water_source' => 'nullable|in:piped,well,spring,others',
            'sanitation_type' => 'nullable|in:sewered,septic_tank,open_pit,others',
            'electricity' => 'nullable|in:available,not_available',
            'education_level' => 'nullable|in:none,elementary,high_school,college,vocational',
            'school_name' => 'nullable|string|max:255',
            'currently_enrolled' => 'nullable|boolean',
            'current_needs' => 'nullable|string',
            'intervention_provided' => 'nullable|string',
            'assessment_statement' => 'nullable|string',
            'recommendations' => 'nullable|string',
        ]);

        $assessment = Assessment::create(array_merge($validated, [
            'created_by' => Auth::id(),
            'status' => 'draft',
        ]));

        $assessment->calculateTotalExpenses();

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'create',
            'module' => 'assessments',
            'description' => "Created assessment for patient ID: {$assessment->patient_id}",
            'patient_id' => $assessment->patient_id,
            'assessment_id' => $assessment->id,
            'new_values' => $assessment->toArray(),
        ]);

        return redirect()->route('assessments.show', $assessment)->with('success', 'Assessment created successfully.');
    }

    public function show(Assessment $assessment)
    {
        $assessment->load(['patient', 'createdBy', 'documents']);
        return view('assessments.show', compact('assessment'));
    }

    public function edit(Assessment $assessment)
    {
        $assessment->load('patient');
        return view('assessments.edit', compact('assessment'));
    }

    public function update(Request $request, Assessment $assessment)
    {
        $validated = $request->validate([
            'father_name' => 'nullable|string|max:255',
            'father_occupation' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'mother_occupation' => 'nullable|string|max:255',
            'family_members' => 'nullable|integer',
            'siblings' => 'nullable|integer',
            'birth_order' => 'nullable|integer',
            'family_composition' => 'nullable|string',
            'family_income_source' => 'nullable|string',
            'monthly_income' => 'nullable|numeric',
            'classification' => 'nullable|in:a,b,c,d',
            'classification_remarks' => 'nullable|string',
            'medical_history' => 'nullable|string',
            'current_diagnosis' => 'nullable|string',
            'hospital_name' => 'nullable|string|max:255',
            'admission_date' => 'nullable|date',
            'discharge_date' => 'nullable|date',
            'food_expenses' => 'nullable|numeric',
            'rent_expenses' => 'nullable|numeric',
            'utilities_expenses' => 'nullable|numeric',
            'transportation_expenses' => 'nullable|numeric',
            'medical_expenses' => 'nullable|numeric',
            'education_expenses' => 'nullable|numeric',
            'other_expenses' => 'nullable|numeric',
            'presenting_problems' => 'nullable|string',
            'client_concerns' => 'nullable|string',
            'housing_type' => 'nullable|in:owned,rented,shared,informal_settler',
            'housing_condition' => 'nullable|string',
            'water_source' => 'nullable|in:piped,well,spring,others',
            'sanitation_type' => 'nullable|in:sewered,septic_tank,open_pit,others',
            'electricity' => 'nullable|in:available,not_available',
            'education_level' => 'nullable|in:none,elementary,high_school,college,vocational',
            'school_name' => 'nullable|string|max:255',
            'currently_enrolled' => 'nullable|boolean',
            'current_needs' => 'nullable|string',
            'intervention_provided' => 'nullable|string',
            'assessment_statement' => 'nullable|string',
            'recommendations' => 'nullable|string',
        ]);

        $oldValues = $assessment->toArray();
        $assessment->update($validated);
        $assessment->calculateTotalExpenses();

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'update',
            'module' => 'assessments',
            'description' => "Updated assessment ID: {$assessment->id}",
            'patient_id' => $assessment->patient_id,
            'assessment_id' => $assessment->id,
            'old_values' => $oldValues,
            'new_values' => $assessment->toArray(),
        ]);

        return redirect()->route('assessments.show', $assessment)->with('success', 'Assessment updated successfully.');
    }

    public function submit(Assessment $assessment)
    {
        $assessment->update([
            'status' => 'submitted',
            'submitted_at' => now(),
        ]);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'submit',
            'module' => 'assessments',
            'description' => "Submitted assessment ID: {$assessment->id}",
            'patient_id' => $assessment->patient_id,
            'assessment_id' => $assessment->id,
        ]);

        return redirect()->route('assessments.show', $assessment)->with('success', 'Assessment submitted successfully.');
    }

    public function complete(Assessment $assessment)
    {
        $assessment->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'complete',
            'module' => 'assessments',
            'description' => "Completed assessment ID: {$assessment->id}",
            'patient_id' => $assessment->patient_id,
            'assessment_id' => $assessment->id,
        ]);

        return redirect()->route('assessments.show', $assessment)->with('success', 'Assessment completed successfully.');
    }

    public function destroy(Assessment $assessment)
    {
        $patientId = $assessment->patient_id;
        $assessment->delete();

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'delete',
            'module' => 'assessments',
            'description' => "Deleted assessment ID: {$assessment->id}",
            'patient_id' => $patientId,
        ]);

        return redirect()->route('assessments.index')->with('success', 'Assessment deleted successfully.');
    }
}
