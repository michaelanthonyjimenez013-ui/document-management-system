@extends('layouts.app')

@section('page-title', 'Assessment Details')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-clipboard-data me-2"></i>Assessment Details</span>
                <div class="btn-group btn-group-sm">
                    @if($assessment->status === 'draft')
                    <a href="{{ route('assessments.edit', $assessment) }}" class="btn btn-outline-primary">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <form action="{{ route('assessments.submit', $assessment) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-info" onclick="return confirm('Submit this assessment?')">
                            <i class="bi bi-send"></i> Submit
                        </button>
                    </form>
                    @elseif($assessment->status === 'submitted')
                    <form action="{{ route('assessments.complete', $assessment) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-success" onclick="return confirm('Mark as completed?')">
                            <i class="bi bi-check-circle"></i> Complete
                        </button>
                    </form>
                    @endif
                    <a href="{{ route('export.assessment', $assessment) }}" class="btn btn-outline-dark">
                        <i class="bi bi-file-earmark-pdf"></i> Export PDF
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Patient:</strong>
                    @if($assessment->patient)
                    <a href="{{ route('patients.show', $assessment->patient) }}">{{ $assessment->patient->full_name }}</a>
                    @else
                    <span class="text-muted">Unknown</span>
                    @endif
                </div>
                <div class="mb-3">
                    <strong>Status:</strong>
                    @if($assessment->status === 'draft')
                    <span class="badge bg-warning">Draft</span>
                    @elseif($assessment->status === 'submitted')
                    <span class="badge bg-info">Submitted</span>
                    @elseif($assessment->status === 'completed')
                    <span class="badge bg-success">Completed</span>
                    @endif
                </div>
                <div class="mb-3">
                    <strong>Created:</strong> {{ $assessment->created_at->format('F d, Y g:i A') }}
                </div>
                
                <hr>
                
                <h5 class="mb-3">Demographic Information</h5>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <p><strong>Father's Name:</strong> {{ $assessment->father_name ?? 'N/A' }}</p>
                        <p><strong>Father's Occupation:</strong> {{ $assessment->father_occupation ?? 'N/A' }}</p>
                        <p><strong>Mother's Name:</strong> {{ $assessment->mother_name ?? 'N/A' }}</p>
                        <p><strong>Mother's Occupation:</strong> {{ $assessment->mother_occupation ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Family Members:</strong> {{ $assessment->family_members ?? 'N/A' }}</p>
                        <p><strong>Siblings:</strong> {{ $assessment->siblings ?? 'N/A' }}</p>
                        <p><strong>Birth Order:</strong> {{ $assessment->birth_order ?? 'N/A' }}</p>
                    </div>
                </div>
                
                <h5 class="mb-3">Family Information</h5>
                <div class="row mb-4">
                    <div class="col-md-12">
                        <p><strong>Family Composition:</strong></p>
                        <p>{{ $assessment->family_composition ?? 'N/A' }}</p>
                        <p><strong>Family Income Source:</strong></p>
                        <p>{{ $assessment->family_income_source ?? 'N/A' }}</p>
                        <p><strong>Monthly Income:</strong> PHP {{ number_format($assessment->monthly_income ?? 0, 2) }}</p>
                    </div>
                </div>
                
                <h5 class="mb-3">MSWD Classification</h5>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <p><strong>Classification:</strong> {{ $assessment->classification ? strtoupper($assessment->classification) : 'N/A' }}</p>
                    </div>
                    <div class="col-md-12">
                        <p><strong>Remarks:</strong></p>
                        <p>{{ $assessment->classification_remarks ?? 'N/A' }}</p>
                    </div>
                </div>
                
                <h5 class="mb-3">Medical History</h5>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <p><strong>Medical History:</strong></p>
                        <p>{{ $assessment->medical_history ?? 'N/A' }}</p>
                        <p><strong>Current Diagnosis:</strong></p>
                        <p>{{ $assessment->current_diagnosis ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Hospital:</strong> {{ $assessment->hospital_name ?? 'N/A' }}</p>
                        <p><strong>Admission Date:</strong> {{ $assessment->admission_date ? $assessment->admission_date->format('F d, Y') : 'N/A' }}</p>
                        <p><strong>Discharge Date:</strong> {{ $assessment->discharge_date ? $assessment->discharge_date->format('F d, Y') : 'N/A' }}</p>
                    </div>
                </div>
                
                <h5 class="mb-3">Monthly Expenses (PHP)</h5>
                <div class="row mb-4">
                    <div class="col-md-4">
                        <p><strong>Food:</strong> {{ number_format($assessment->food_expenses ?? 0, 2) }}</p>
                        <p><strong>Rent:</strong> {{ number_format($assessment->rent_expenses ?? 0, 2) }}</p>
                        <p><strong>Utilities:</strong> {{ number_format($assessment->utilities_expenses ?? 0, 2) }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Transportation:</strong> {{ number_format($assessment->transportation_expenses ?? 0, 2) }}</p>
                        <p><strong>Medical:</strong> {{ number_format($assessment->medical_expenses ?? 0, 2) }}</p>
                        <p><strong>Education:</strong> {{ number_format($assessment->education_expenses ?? 0, 2) }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Other:</strong> {{ number_format($assessment->other_expenses ?? 0, 2) }}</p>
                        <p><strong class="text-primary">Total:</strong> {{ number_format($assessment->total_expenses ?? 0, 2) }}</p>
                    </div>
                </div>
                
                <h5 class="mb-3">Presenting Problems</h5>
                <div class="row mb-4">
                    <div class="col-md-12">
                        <p><strong>Presenting Problems:</strong></p>
                        <p>{{ $assessment->presenting_problems ?? 'N/A' }}</p>
                        <p><strong>Client Concerns:</strong></p>
                        <p>{{ $assessment->client_concerns ?? 'N/A' }}</p>
                    </div>
                </div>
                
                <h5 class="mb-3">Housing Information</h5>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <p><strong>Housing Type:</strong> {{ ucfirst(str_replace('_', ' ', $assessment->housing_type ?? 'N/A')) }}</p>
                        <p><strong>Water Source:</strong> {{ ucfirst($assessment->water_source ?? 'N/A') }}</p>
                        <p><strong>Sanitation:</strong> {{ ucfirst(str_replace('_', ' ', $assessment->sanitation_type ?? 'N/A')) }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Housing Condition:</strong></p>
                        <p>{{ $assessment->housing_condition ?? 'N/A' }}</p>
                        <p><strong>Electricity:</strong> {{ ucfirst($assessment->electricity ?? 'N/A') }}</p>
                    </div>
                </div>
                
                <h5 class="mb-3">Education</h5>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <p><strong>Education Level:</strong> {{ ucfirst($assessment->education_level ?? 'N/A') }}</p>
                        <p><strong>School Name:</strong> {{ $assessment->school_name ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Currently Enrolled:</strong> {{ $assessment->currently_enrolled ? 'Yes' : 'No' }}</p>
                    </div>
                </div>
                
                <h5 class="mb-3">Current Needs & Assessment</h5>
                <div class="row mb-4">
                    <div class="col-md-12">
                        <p><strong>Current Needs:</strong></p>
                        <p>{{ $assessment->current_needs ?? 'N/A' }}</p>
                        <p><strong>Intervention Provided:</strong></p>
                        <p>{{ $assessment->intervention_provided ?? 'N/A' }}</p>
                        <p><strong>Assessment Statement:</strong></p>
                        <p>{{ $assessment->assessment_statement ?? 'N/A' }}</p>
                        <p><strong>Recommendations:</strong></p>
                        <p>{{ $assessment->recommendations ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-info-circle me-2"></i>Assessment Info
            </div>
            <div class="card-body">
                <p><strong>ID:</strong> #{{ $assessment->id }}</p>
                <p><strong>Status:</strong>
                    @if($assessment->status === 'draft')
                    <span class="badge bg-warning">Draft</span>
                    @elseif($assessment->status === 'submitted')
                    <span class="badge bg-info">Submitted</span>
                    @elseif($assessment->status === 'completed')
                    <span class="badge bg-success">Completed</span>
                    @endif
                </p>
                <p><strong>Created By:</strong> {{ $assessment->createdBy->name }}</p>
                <p><strong>Created At:</strong> {{ $assessment->created_at->format('F d, Y g:i A') }}</p>
                @if($assessment->submitted_at)
                <p><strong>Submitted At:</strong> {{ $assessment->submitted_at->format('F d, Y g:i A') }}</p>
                @endif
                @if($assessment->completed_at)
                <p><strong>Completed At:</strong> {{ $assessment->completed_at->format('F d, Y g:i A') }}</p>
                @endif
            </div>
        </div>
        
        <div class="card mt-4">
            <div class="card-header">
                <i class="bi bi-file-earmark me-2"></i>Related Documents
            </div>
            <div class="card-body">
                @if($assessment->documents->count() > 0)
                <ul class="list-unstyled">
                    @foreach($assessment->documents as $document)
                    <li class="mb-2">
                        <a href="{{ route('documents.download', $document) }}">
                            <i class="bi bi-file-earmark me-1"></i>
                            {{ $document->file_name }}
                        </a>
                    </li>
                    @endforeach
                </ul>
                @else
                <p class="text-muted">No documents attached</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
