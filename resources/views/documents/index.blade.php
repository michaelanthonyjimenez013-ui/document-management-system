@extends('layouts.app')

@section('page-title', 'Documents')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-file-earmark me-2"></i>Document Management</span>
        <a href="{{ route('documents.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Upload Document
        </a>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-4">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search documents..." id="searchInput">
                    <button class="btn btn-outline-secondary" type="button">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-3">
                <select class="form-select" id="categoryFilter">
                    <option value="">All Categories</option>
                    <option value="mswd_assessment_form">MSWD Assessment Form</option>
                    <option value="medical_certificate">Medical Certificate</option>
                    <option value="birth_certificate">Birth Certificate</option>
                    <option value="valid_id">Valid ID</option>
                    <option value="barangay_certificate">Barangay Certificate</option>
                    <option value="hospital_bill">Hospital Bill</option>
                    <option value="laboratory_result">Laboratory Result</option>
                    <option value="prescription">Prescription</option>
                    <option value="referral_letter">Referral Letter</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="col-md-5 text-end">
                <button id="bulkPrintBtn" class="btn btn-success" disabled>
                    <i class="bi bi-printer me-1"></i> Print Selected
                </button>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th width="50">
                            <input type="checkbox" id="selectAll" class="form-check-input">
                        </th>
                        <th>File Name</th>
                        <th>Category</th>
                        <th>Patient</th>
                        <th>Size</th>
                        <th>Uploaded By</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($documents as $document)
                    <tr>
                        <td>
                            <input type="checkbox" class="form-check-input document-checkbox" value="{{ $document->id }}" data-file-path="{{ $document->file_path }}" data-file-name="{{ $document->file_name }}">
                        </td>
                        <td>
                            <a href="{{ route('documents.show', $document) }}" class="text-decoration-none">
                                <i class="bi bi-file-earmark me-1"></i>
                                {{ $document->file_name }}
                            </a>
                        </td>
                        <td>
                            <span class="badge bg-secondary">{{ ucfirst(str_replace('_', ' ', $document->category)) }}</span>
                        </td>
                        <td>
                            @if($document->patient)
                            <a href="{{ route('patients.show', $document->patient) }}">
                                {{ $document->patient->full_name }}
                            </a>
                            @else
                            <span class="text-muted">Unknown</span>
                            @endif
                        </td>
                        <td>{{ $document->file_size_in_kb }}</td>
                        <td>{{ $document->uploadedBy->name }}</td>
                        <td>{{ $document->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('documents.show', $document) }}" class="btn btn-outline-info" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('documents.download', $document) }}" class="btn btn-outline-primary" title="Download">
                                    <i class="bi bi-download"></i>
                                </a>
                                <form action="{{ route('documents.destroy', $document) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Delete" onclick="return confirm('Are you sure?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        {{ $documents->links('pagination::bootstrap-5') }}
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('selectAll');
    const documentCheckboxes = document.querySelectorAll('.document-checkbox');
    const bulkPrintBtn = document.getElementById('bulkPrintBtn');

    // Select all functionality
    selectAllCheckbox.addEventListener('change', function() {
        documentCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateBulkPrintButton();
    });

    // Individual checkbox change
    documentCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateBulkPrintButton();
            // Update select all checkbox state
            const allChecked = Array.from(documentCheckboxes).every(cb => cb.checked);
            const someChecked = Array.from(documentCheckboxes).some(cb => cb.checked);
            selectAllCheckbox.checked = allChecked;
            selectAllCheckbox.indeterminate = someChecked && !allChecked;
        });
    });

    // Update bulk print button state
    function updateBulkPrintButton() {
        const selectedCount = Array.from(documentCheckboxes).filter(cb => cb.checked).length;
        bulkPrintBtn.disabled = selectedCount === 0;
        if (selectedCount > 0) {
            bulkPrintBtn.innerHTML = `<i class="bi bi-printer me-1"></i> Print Selected (${selectedCount})`;
        } else {
            bulkPrintBtn.innerHTML = `<i class="bi bi-printer me-1"></i> Print Selected`;
        }
    }

    // Bulk print functionality
    bulkPrintBtn.addEventListener('click', function() {
        const selectedDocuments = Array.from(documentCheckboxes)
            .filter(cb => cb.checked)
            .map(cb => ({
                id: cb.value,
                filePath: cb.dataset.filePath,
                fileName: cb.dataset.fileName
            }));

        if (selectedDocuments.length === 0) {
            alert('Please select at least one document to print.');
            return;
        }

        // Send request to bulk print endpoint
        fetch('{{ route('documents.bulk-print') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                documents: selectedDocuments
            })
        })
        .then(response => response.blob())
        .then(blob => {
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'bulk_print_' + new Date().toISOString().slice(0,10) + '.pdf';
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
            document.body.removeChild(a);
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while generating the bulk print PDF.');
        });
    });
});
</script>
@endsection
