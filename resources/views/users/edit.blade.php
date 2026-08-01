@extends('layouts.app')

@section('page-title', 'Edit User')

@section('content')
<div class="card">
    <div class="card-header">
        <i class="bi bi-pencil me-2"></i>Edit User
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('users.update', $user) }}">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="name" class="form-label">Name *</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                @error('name')
                <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="email" class="form-label">Email *</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                @error('email')
                <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="role" class="form-label">Role *</label>
                <select class="form-select" id="role" name="role" required>
                    <option value="">Select Role</option>
                    <option value="administrator" {{ old('role', $user->role) === 'administrator' ? 'selected' : '' }}>Administrator</option>
                    <option value="medical_social_worker" {{ old('role', $user->role) === 'medical_social_worker' ? 'selected' : '' }}>Medical Social Worker</option>
                    <option value="records_officer" {{ old('role', $user->role) === 'records_officer' ? 'selected' : '' }}>Records Officer</option>
                </select>
                @error('role')
                <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="is_active" class="form-label">Status *</label>
                <select class="form-select" id="is_active" name="is_active" required>
                    <option value="1" {{ old('is_active', $user->is_active) === '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('is_active', $user->is_active) === '0' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('is_active')
                <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="d-flex justify-content-between">
                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle me-1"></i> Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-1"></i> Update User
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
