@extends('layouts.app')

@section('page-title', 'Patients Report')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-people me-2"></i>Patients Report</span>
        <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <strong>Total Patients:</strong> {{ $patients->count() }}
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>HRN</th>
                        <th>MSWD Number</th>
                        <th>Name</th>
                        <th>Age/Sex</th>
                        <th>Contact</th>
                        <th>Address</th>
                        <th>Status</th>
                        <th>Registered Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($patients as $patient)
                    <tr>
                        <td>{{ $patient->health_record_number }}</td>
                        <td>{{ $patient->mswd_number ?? 'N/A' }}</td>
                        <td>{{ $patient->full_name }}</td>
                        <td>{{ $patient->age }} / {{ ucfirst($patient->sex) }}</td>
                        <td>{{ $patient->mobile_number ?? $patient->phone_number ?? 'N/A' }}</td>
                        <td>{{ $patient->barangay }}, {{ $patient->city_municipality }}</td>
                        <td>{{ ucfirst($patient->status) }}</td>
                        <td>{{ $patient->created_at->format('M d, Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
