@extends('layouts.app')

@section('page-title', 'Assessments Report')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-clipboard-data me-2"></i>Assessments Report</span>
        <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <strong>Total Assessments:</strong> {{ $assessments->count() }}
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Patient</th>
                        <th>Status</th>
                        <th>Classification</th>
                        <th>Created By</th>
                        <th>Date Created</th>
                        <th>Submitted</th>
                        <th>Completed</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($assessments as $assessment)
                    <tr>
                        <td>#{{ $assessment->id }}</td>
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
                        <td>{{ $assessment->createdBy->name }}</td>
                        <td>{{ $assessment->created_at->format('M d, Y') }}</td>
                        <td>{{ $assessment->submitted_at ? $assessment->submitted_at->format('M d, Y') : 'N/A' }}</td>
                        <td>{{ $assessment->completed_at ? $assessment->completed_at->format('M d, Y') : 'N/A' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
