@extends('layouts.app')

@section('page-title', 'Patients')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-people me-2"></i>Patient Management</span>
        <a href="{{ route('patients.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Add Patient
        </a>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search patients..." id="searchInput">
                    <button class="btn btn-outline-secondary" type="button">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>HRN</th>
                        <th>Name</th>
                        <th>Age/Sex</th>
                        <th>Contact</th>
                        <th>Address</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($patients as $patient)
                    <tr>
                        <td>{{ $patient->health_record_number }}</td>
                        <td>
                            <a href="{{ route('patients.show', $patient) }}">
                                {{ $patient->full_name }}
                            </a>
                        </td>
                        <td>{{ $patient->age }} / {{ ucfirst($patient->sex) }}</td>
                        <td>{{ $patient->mobile_number ?? $patient->phone_number ?? '-' }}</td>
                        <td>{{ $patient->barangay }}, {{ $patient->city_municipality }}</td>
                        <td>
                            <span class="badge bg-{{ $patient->status === 'active' ? 'success' : 'secondary' }}">
                                {{ ucfirst($patient->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('patients.show', $patient) }}" class="btn btn-outline-primary" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('patients.edit', $patient) }}" class="btn btn-outline-secondary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                @if(auth()->user()->canDeletePatients())
                                <form action="{{ route('patients.destroy', $patient) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Delete" onclick="return confirm('Are you sure?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        {{ $patients->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
