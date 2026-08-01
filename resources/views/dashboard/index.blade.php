@extends('layouts.app')

@section('page-title', 'Dashboard')

@section('content')
<div class="mb-4">
    <h2 class="mb-1">
        Hello, {{ auth()->user()->name }}!
    </h2>
    <p class="text-muted">Here's what's happening today.</p>
</div>
<div class="row">
    <!-- Statistics Cards -->
    <div class="col-md-3">
        <div class="stat-card primary">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-value">{{ $totalPatients }}</div>
                    <div class="stat-label">Total Patients</div>
                </div>
                <div class="stat-icon">
                    <i class="bi bi-people"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stat-card success">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-value">{{ $activeCases }}</div>
                    <div class="stat-label">Active Cases</div>
                </div>
                <div class="stat-icon">
                    <i class="bi bi-activity"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stat-card warning">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-value">{{ $pendingAssessments }}</div>
                    <div class="stat-label">Pending Assessments</div>
                </div>
                <div class="stat-icon">
                    <i class="bi bi-clipboard-pulse"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stat-card info">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-value">{{ $totalDocuments }}</div>
                    <div class="stat-label">Total Documents</div>
                </div>
                <div class="stat-icon">
                    <i class="bi bi-file-earmark"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <!-- Recent Patients -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-people me-2"></i>Recent Patients</span>
                <a href="{{ route('patients.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                @if($recentPatients->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>HRN</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentPatients as $patient)
                            <tr>
                                <td>
                                    <a href="{{ route('patients.show', $patient) }}">
                                        {{ $patient->full_name }}
                                    </a>
                                </td>
                                <td>{{ $patient->health_record_number }}</td>
                                <td>
                                    <span class="badge bg-success">Active</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center text-muted py-4">
                    <i class="bi bi-inbox fs-1"></i>
                    <p class="mt-2">No patients registered yet</p>
                    <a href="{{ route('patients.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> Register Patient
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Recent Assessments -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-clipboard-data me-2"></i>Recent Assessments</span>
                <a href="{{ route('assessments.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                @if($recentAssessments->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Patient</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentAssessments as $assessment)
                            <tr>
                                <td>
                                    @if($assessment->patient)
                                    <a href="{{ route('patients.show', $assessment->patient) }}">
                                        {{ $assessment->patient->full_name }}
                                    </a>
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
                                <td>{{ $assessment->created_at->format('M d, Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center text-muted py-4">
                    <i class="bi bi-clipboard-x fs-1"></i>
                    <p class="mt-2">No assessments created yet</p>
                    <a href="{{ route('assessments.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> Create Assessment
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <!-- Recent Documents -->
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-file-earmark me-2"></i>Recent Documents</span>
                <a href="{{ route('documents.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                @if($recentDocuments->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>File Name</th>
                                <th>Category</th>
                                <th>Patient</th>
                                <th>Uploaded By</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentDocuments as $document)
                            <tr>
                                <td>
                                    <a href="{{ route('documents.show', $document) }}" class="text-decoration-none">
                                        <i class="bi bi-file-earmark me-1"></i>
                                        {{ $document->file_name }}
                                    </a>
                                </td>
                                <td>{{ ucfirst(str_replace('_', ' ', $document->category)) }}</td>
                                <td>
                                    @if($document->patient)
                                    <a href="{{ route('patients.show', $document->patient) }}">
                                        {{ $document->patient->full_name }}
                                    </a>
                                    @else
                                    <span class="text-muted">Unknown</span>
                                    @endif
                                </td>
                                <td>{{ $document->uploadedBy->name }}</td>
                                <td>{{ $document->created_at->format('M d, Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center text-muted py-4">
                    <i class="bi bi-file-earmark-x fs-1"></i>
                    <p class="mt-2">No documents uploaded yet</p>
                    <a href="{{ route('documents.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-upload me-1"></i> Upload Document
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <!-- Recent Activity -->
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-clock-history me-2"></i>Recent Activity</span>
                <a href="{{ route('audit-logs.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                @if($recentActivities->count() > 0)
                    <div class="timeline">
                        @foreach($recentActivities as $activity)
                            <div class="d-flex align-items-start mb-3 pb-3 border-bottom">
                                <div class="flex-shrink-0 me-3">
                                    <div class="user-avatar" style="width: 36px; height: 36px; font-size: 14px;">
                                        {{ strtoupper(substr($activity->user->name ?? 'U', 0, 1)) }}
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <h6 class="mb-0">{{ $activity->user->name ?? 'Unknown User' }}</h6>
                                        <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                                    </div>
                                    <p class="mb-0 text-muted">{{ $activity->description }}</p>
                                    <span class="badge bg-secondary mt-1">{{ ucfirst($activity->module) }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-inbox fs-1"></i>
                        <p class="mt-2">No recent activity</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Dashboard loaded');
    });
</script>
@endpush
