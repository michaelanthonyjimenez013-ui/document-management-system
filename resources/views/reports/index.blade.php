@extends('layouts.app')

@section('page-title', 'Reports')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <i class="bi bi-people fs-1 text-primary mb-3"></i>
                <h5>Patient Reports</h5>
                <p class="text-muted">View and export patient data</p>
                <a href="{{ route('reports.patients') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-right me-1"></i> View Patients Report
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <i class="bi bi-clipboard-data fs-1 text-success mb-3"></i>
                <h5>Assessment Reports</h5>
                <p class="text-muted">View and export assessment data</p>
                <a href="{{ route('reports.assessments') }}" class="btn btn-success">
                    <i class="bi bi-arrow-right me-1"></i> View Assessments Report
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <i class="bi bi-file-earmark fs-1 text-info mb-3"></i>
                <h5>Document Reports</h5>
                <p class="text-muted">View and export document data</p>
                <a href="{{ route('reports.documents') }}" class="btn btn-info">
                    <i class="bi bi-arrow-right me-1"></i> View Documents Report
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
