<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::active()->latest()->paginate(10);
        return view('patients.index', compact('patients'));
    }

    public function create()
    {
        return view('patients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'health_record_number' => 'required|unique:patients',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'suffix' => 'nullable|string|max:10',
            'birth_date' => 'required|date',
            'age' => 'required|string|max:10',
            'sex' => 'required|in:male,female',
            'civil_status' => 'required|in:single,married,widowed,separated,divorced',
            'place_of_birth' => 'required|string|max:255',
            'nationality' => 'required|string|max:255',
            'religion' => 'nullable|string|max:255',
            'guardian_name' => 'nullable|string|max:255',
            'guardian_relationship' => 'nullable|string|max:255',
            'guardian_contact' => 'nullable|string|max:20',
            'phone_number' => 'nullable|string|max:20',
            'mobile_number' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'house_number' => 'nullable|string|max:255',
            'street' => 'nullable|string|max:255',
            'barangay' => 'required|string|max:255',
            'city_municipality' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'zip_code' => 'nullable|string|max:10',
        ]);

        $patient = Patient::create(array_merge($validated, [
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]));

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'create',
            'module' => 'patients',
            'description' => "Created patient: {$patient->full_name}",
            'patient_id' => $patient->id,
            'new_values' => $patient->toArray(),
        ]);

        return redirect()->route('patients.show', $patient)->with('success', 'Patient created successfully.');
    }

    public function show(Patient $patient)
    {
        $patient->load(['assessments', 'documents']);
        return view('patients.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'health_record_number' => 'required|unique:patients,health_record_number,' . $patient->id,
            'mswd_number' => 'nullable|unique:patients,mswd_number,' . $patient->id,
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'suffix' => 'nullable|string|max:10',
            'birth_date' => 'required|date',
            'age' => 'required|string|max:10',
            'sex' => 'required|in:male,female',
            'civil_status' => 'required|in:single,married,widowed,separated,divorced',
            'place_of_birth' => 'required|string|max:255',
            'nationality' => 'required|string|max:255',
            'religion' => 'nullable|string|max:255',
            'guardian_name' => 'nullable|string|max:255',
            'guardian_relationship' => 'nullable|string|max:255',
            'guardian_contact' => 'nullable|string|max:20',
            'phone_number' => 'nullable|string|max:20',
            'mobile_number' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'house_number' => 'nullable|string|max:255',
            'street' => 'nullable|string|max:255',
            'barangay' => 'required|string|max:255',
            'city_municipality' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'zip_code' => 'nullable|string|max:10',
        ]);

        $oldValues = $patient->toArray();
        $patient->update(array_merge($validated, ['updated_by' => Auth::id()]));

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'update',
            'module' => 'patients',
            'description' => "Updated patient: {$patient->full_name}",
            'patient_id' => $patient->id,
            'old_values' => $oldValues,
            'new_values' => $patient->toArray(),
        ]);

        return redirect()->route('patients.show', $patient)->with('success', 'Patient updated successfully.');
    }

    public function destroy(Patient $patient)
    {
        if (!Auth::user()->canDeletePatients()) {
            abort(403, 'Unauthorized action.');
        }

        $patientName = $patient->full_name;
        $patient->delete();

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'delete',
            'module' => 'patients',
            'description' => "Deleted patient: {$patientName}",
            'patient_id' => $patient->id,
        ]);

        return redirect()->route('patients.index')->with('success', 'Patient deleted successfully.');
    }

    public function archive(Patient $patient)
    {
        $patient->update(['status' => 'archived']);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'archive',
            'module' => 'patients',
            'description' => "Archived patient: {$patient->full_name}",
            'patient_id' => $patient->id,
        ]);

        return redirect()->route('patients.index')->with('success', 'Patient archived successfully.');
    }

    public function restore(Patient $patient)
    {
        $patient->update(['status' => 'active']);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'restore',
            'module' => 'patients',
            'description' => "Restored patient: {$patient->full_name}",
            'patient_id' => $patient->id,
        ]);

        return redirect()->route('patients.index')->with('success', 'Patient restored successfully.');
    }
}
