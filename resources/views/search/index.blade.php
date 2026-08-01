@extends('layouts.app')

@section('page-title', 'Search')

@section('content')
<div class="card">
    <div class="card-header">
        <i class="bi bi-search me-2"></i>Search Records
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('search') }}">
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" placeholder="Search by name, HRN, MSWD number, or document name..." value="{{ $query ?? '' }}">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i> Search
                        </button>
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="type">
                        <option value="all" {{ $type === 'all' ? 'selected' : '' }}>All Records</option>
                        <option value="patients" {{ $type === 'patients' ? 'selected' : '' }}>Patients Only</option>
                        <option value="assessments" {{ $type === 'assessments' ? 'selected' : '' }}>Assessments Only</option>
                        <option value="documents" {{ $type === 'documents' ? 'selected' : '' }}>Documents Only</option>
                    </select>
                </div>
            </div>
        </form>
        
        @if(isset($query))
        <div class="row mt-4">
            @if($patients->count() > 0)
            <div class="col-12 mb-4">
                <h5><i class="bi bi-people me-2"></i>Patients ({{ $patients->count() }})</h5>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>HRN</th>
                                <th>Name</th>
                                <th>Age/Sex</th>
                                <th>Contact</th>
                                <th>Address</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($patients as $patient)
                            <tr>
                                <td>{{ $patient->health_record_number }}</td>
                                <td>{{ $patient->full_name }}</td>
                                <td>{{ $patient->age }} / {{ ucfirst($patient->sex) }}</td>
                                <td>{{ $patient->mobile_number ?? $patient->phone_number ?? '-' }}</td>
                                <td>{{ $patient->barangay }}, {{ $patient->city_municipality }}</td>
                                <td>
                                    <a href="{{ route('patients.show', $patient) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
            
            @if($assessments->count() > 0)
            <div class="col-12 mb-4">
                <h5><i class="bi bi-clipboard-data me-2"></i>Assessments ({{ $assessments->count() }})</h5>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Patient</th>
                                <th>Status</th>
                                <th>Classification</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($assessments as $assessment)
                            <tr>
                                <td>
                                    @if($assessment->patient)
                                    {{ $assessment->patient->full_name }}
                                    @else
                                    <span class="text-muted">Unknown</span>
                                    @endif
                                </td>
                                <td>
                                    @if($assessment->status === 'draft')
                                    <span class="badge bg-warning">Draft</span>
                                    @elseif($assessment->status === 'submitted')
                                    <span class="badge bg-info">Submitted</span>
                                    @elseif($assessment->status === 'completed')
                                    <span class="badge bg-success">Completed</span>
                                    @endif
                                </td>
                                <td>{{ $assessment->classification ? strtoupper($assessment->classification) : 'N/A' }}</td>
                                <td>{{ $assessment->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('assessments.show', $assessment) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
            
            @if($documents->count() > 0)
            <div class="col-12 mb-4">
                <h5><i class="bi bi-file-earmark me-2"></i>Documents ({{ $documents->count() }})</h5>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>File Name</th>
                                <th>Category</th>
                                <th>Patient</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($documents as $document)
                            <tr>
                                <td>{{ $document->file_name }}</td>
                                <td>{{ ucfirst(str_replace('_', ' ', $document->category)) }}</td>
                                <td>
                                    @if($document->patient)
                                    {{ $document->patient->full_name }}
                                    @else
                                    <span class="text-muted">Unknown</span>
                                    @endif
                                </td>
                                <td>{{ $document->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('documents.download', $document) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-download"></i> Download
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
            
            @if($patients->count() === 0 && $assessments->count() === 0 && $documents->count() === 0)
            <div class="col-12">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    No results found for "{{ $query }}"
                </div>
            </div>
            @endif
        </div>
        @endif
    </div>
</div>
@endsection
