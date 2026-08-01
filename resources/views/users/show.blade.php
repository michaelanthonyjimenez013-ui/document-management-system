@extends('layouts.app')

@section('page-title', 'User Details')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-person me-2"></i>User Information</span>
                <div class="btn-group btn-group-sm">
                    <a href="{{ route('users.edit', $user) }}" class="btn btn-outline-primary">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td class="fw-bold" style="width: 30%;">Name:</td>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Email:</td>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Role:</td>
                        <td>
                            <span class="badge bg-{{ $user->role === 'administrator' ? 'danger' : ($user->role === 'medical_social_worker' ? 'primary' : 'secondary') }}">
                                {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Status:</td>
                        <td>
                            @if($user->is_active)
                            <span class="badge bg-success">Active</span>
                            @else
                            <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Created At:</td>
                        <td>{{ $user->created_at->format('F d, Y g:i A') }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Last Updated:</td>
                        <td>{{ $user->updated_at->format('F d, Y g:i A') }}</td>
                    </tr>
                </table>
            </div>
        </div>
        
        <div class="card mt-4">
            <div class="card-header">
                <i class="bi bi-people me-2"></i>Activity Summary
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3 mb-3">
                        <div class="h4">{{ $user->patientsCreated->count() }}</div>
                        <small class="text-muted">Patients Created</small>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="h4">{{ $user->assessments->count() }}</div>
                        <small class="text-muted">Assessments Created</small>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="h4">{{ $user->documents->count() }}</div>
                        <small class="text-muted">Documents Uploaded</small>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="h4">{{ $user->auditLogs->count() }}</div>
                        <small class="text-muted">Audit Logs</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-info-circle me-2"></i>Quick Actions
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('users.edit', $user) }}" class="btn btn-primary">
                        <i class="bi bi-pencil me-2"></i>Edit User
                    </a>
                    @if($user->id !== auth()->id())
                    <form action="{{ route('users.destroy', $user) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Are you sure you want to delete this user?')">
                            <i class="bi bi-trash me-2"></i>Delete User
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
