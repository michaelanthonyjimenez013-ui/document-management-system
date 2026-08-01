@extends('layouts.app')

@section('page-title', 'Upload Document')

@section('content')
<div class="card">
    <div class="card-header">
        <i class="bi bi-upload me-2"></i>Upload Document
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('documents.upload') }}" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-3">
                <label for="patient_id" class="form-label">Patient *</label>
                <select class="form-select" id="patient_id" name="patient_id" required>
                    <option value="">Select Patient</option>
                    @foreach($patients as $patient)
                    <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                        {{ $patient->full_name }} ({{ $patient->health_record_number }})
                    </option>
                    @endforeach
                </select>
                @error('patient_id')
                <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="assessment_id" class="form-label">Assessment (Optional)</label>
                <select class="form-select" id="assessment_id" name="assessment_id">
                    <option value="">Select Assessment</option>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="file" class="form-label">File *</label>
                <input type="file" class="form-control" id="file" name="file" required accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                @error('file')
                <div class="text-danger small">{{ $message }}</div>
                @enderror
                <small class="text-muted">Accepted formats: PDF, DOC, DOCX, JPG, JPEG, PNG (Max: 10MB)</small>
            </div>
            
            <div class="mb-3">
                <label for="category" class="form-label">Category *</label>
                <select class="form-select" id="category" name="category" required>
                    <option value="">Select Category</option>
                    <option value="mswd_assessment_form" {{ old('category') === 'mswd_assessment_form' ? 'selected' : '' }}>MSWD Assessment Form</option>
                    <option value="medical_certificate" {{ old('category') === 'medical_certificate' ? 'selected' : '' }}>Medical Certificate</option>
                    <option value="birth_certificate" {{ old('category') === 'birth_certificate' ? 'selected' : '' }}>Birth Certificate</option>
                    <option value="valid_id" {{ old('category') === 'valid_id' ? 'selected' : '' }}>Valid ID</option>
                    <option value="barangay_certificate" {{ old('category') === 'barangay_certificate' ? 'selected' : '' }}>Barangay Certificate</option>
                    <option value="hospital_bill" {{ old('category') === 'hospital_bill' ? 'selected' : '' }}>Hospital Bill</option>
                    <option value="laboratory_result" {{ old('category') === 'laboratory_result' ? 'selected' : '' }}>Laboratory Result</option>
                    <option value="prescription" {{ old('category') === 'prescription' ? 'selected' : '' }}>Prescription</option>
                    <option value="referral_letter" {{ old('category') === 'referral_letter' ? 'selected' : '' }}>Referral Letter</option>
                    <option value="other" {{ old('category') === 'other' ? 'selected' : '' }}>Other Supporting Documents</option>
                </select>
                @error('category')
                <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
            </div>
            
            <div class="d-flex justify-content-between">
                <a href="{{ route('documents.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle me-1"></i> Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-upload me-1"></i> Upload Document
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('patient_id').addEventListener('change', function() {
        const patientId = this.value;
        const assessmentSelect = document.getElementById('assessment_id');
        
        if (patientId) {
            fetch(`/api/patients/${patientId}/assessments`)
                .then(response => response.json())
                .then(data => {
                    assessmentSelect.innerHTML = '<option value="">Select Assessment</option>';
                    data.forEach(assessment => {
                        assessmentSelect.innerHTML += `<option value="${assessment.id}">Assessment #${assessment.id} - ${assessment.created_at}</option>`;
                    });
                });
        } else {
            assessmentSelect.innerHTML = '<option value="">Select Assessment</option>';
        }
    });
</script>
@endpush
