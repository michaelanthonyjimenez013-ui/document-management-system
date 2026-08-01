@extends('layouts.app')

@section('page-title', 'Audit Logs')

@section('content')
<div class="card">
    <div class="card-header">
        <i class="bi bi-clock-history me-2"></i>Audit Logs
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Date/Time</th>
                        <th>User</th>
                        <th>Action</th>
                        <th>Module</th>
                        <th>Description</th>
                        <th>IP Address</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($auditLogs as $log)
                    <tr>
                        <td>{{ $log->created_at->format('M d, Y g:i A') }}</td>
                        <td>{{ $log->user->name }}</td>
                        <td>
                            <span class="badge bg-{{ $log->action === 'create' ? 'success' : ($log->action === 'update' ? 'info' : ($log->action === 'delete' ? 'danger' : 'secondary')) }}">
                                {{ ucfirst($log->action) }}
                            </span>
                        </td>
                        <td>{{ ucfirst($log->module) }}</td>
                        <td>{{ $log->description }}</td>
                        <td>{{ $log->ip_address ?? 'N/A' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        {{ $auditLogs->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
