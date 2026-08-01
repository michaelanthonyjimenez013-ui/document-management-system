@extends('layouts.app')

@section('page-title', 'Documents Report')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-file-earmark me-2"></i>Documents Report</span>
        <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <strong>Total Documents:</strong> {{ $documents->count() }}
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>File Name</th>
                        <th>Category</th>
                        <th>Patient</th>
                        <th>File Size</th>
                        <th>Uploaded By</th>
                        <th>Date Uploaded</th>
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
                        <td>{{ $document->formatted_file_size }}</td>
                        <td>{{ $document->uploadedBy->name }}</td>
                        <td>{{ $document->created_at->format('M d, Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
