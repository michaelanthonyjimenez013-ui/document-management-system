@extends('layouts.app')

@section('page-title', 'Document: ' . $document->file_name)

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <i class="bi bi-file-earmark me-2"></i>
            {{ $document->file_name }}
        </div>
        <div class="d-flex gap-2">
            <button onclick="printDocument()" class="btn btn-outline-primary btn-sm">
                <i class="bi bi-printer me-1"></i> Print
            </button>
            <a href="{{ route('documents.download', $document) }}" class="btn btn-primary btn-sm">
                <i class="bi bi-download me-1"></i> Download
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row mb-4 no-print">
            <div class="col-md-6">
                <p class="mb-1"><strong>Category:</strong> {{ ucfirst(str_replace('_', ' ', $document->category)) }}</p>
                <p class="mb-1"><strong>Patient:</strong> 
                    @if($document->patient)
                    <a href="{{ route('patients.show', $document->patient) }}">{{ $document->patient->full_name }}</a>
                    @else
                    <span class="text-muted">Unknown</span>
                    @endif
                </p>
                <p class="mb-1"><strong>Uploaded By:</strong> {{ $document->uploadedBy->name }}</p>
                <p class="mb-1"><strong>Upload Date:</strong> {{ $document->created_at->format('F d, Y h:i A') }}</p>
                <p class="mb-1"><strong>File Size:</strong> {{ $document->file_size_in_kb }}</p>
            </div>
            <div class="col-md-6">
                @if($document->description)
                <p><strong>Description:</strong></p>
                <p class="text-muted">{{ $document->description }}</p>
                @endif
            </div>
        </div>

        <div class="border rounded p-3 bg-light">
            @if($document->isImage())
                <img src="{{ asset('storage/' . $document->file_path) }}" alt="{{ $document->file_name }}" class="img-fluid">
            @elseif($document->isPdf())
                <iframe src="{{ asset('storage/' . $document->file_path) }}" class="w-100" style="height: 800px;"></iframe>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-file-earmark fs-1 text-muted"></i>
                    <p class="mt-3">Preview not available for this file type.</p>
                    <a href="{{ route('documents.download', $document) }}" class="btn btn-primary">
                        <i class="bi bi-download me-1"></i> Download to view
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
@media print {
    .sidebar,
    .main-content > div:first-child,
    .card-header,
    .no-print {
        display: none !important;
    }
    
    .main-content {
        margin-left: 0 !important;
        padding: 0;
    }
    
    .card {
        border: none;
        box-shadow: none;
        margin: 0;
    }
    
    .card-body {
        padding: 0;
    }
    
    .border.rounded.p-3.bg-light {
        border: none;
        padding: 0;
        background: none;
    }
}
</style>

<script>
function printDocument() {
    @if($document->isPdf())
        const iframe = document.querySelector('iframe');
        if (iframe) {
            iframe.contentWindow.print();
        }
    @else
        window.print();
    @endif
}
</script>
@endsection
