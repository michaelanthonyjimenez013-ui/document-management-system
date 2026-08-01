<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bulk Document Print</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            color: #333;
        }
        .header p {
            margin: 5px 0 0;
            color: #666;
        }
        .document-section {
            margin-bottom: 40px;
            page-break-inside: avoid;
        }
        .document-header {
            background-color: #f5f5f5;
            padding: 15px;
            border-left: 4px solid #007bff;
            margin-bottom: 15px;
        }
        .document-header h3 {
            margin: 0 0 10px;
            color: #333;
        }
        .document-info {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            font-size: 12px;
            color: #666;
        }
        .document-info div {
            margin: 0;
        }
        .document-info strong {
            color: #333;
        }
        .document-content {
            padding: 20px;
            border: 1px solid #ddd;
            background-color: #fff;
            min-height: 200px;
        }
        .badge {
            display: inline-block;
            padding: 4px 8px;
            font-size: 11px;
            font-weight: bold;
            background-color: #6c757d;
            color: white;
            border-radius: 3px;
            text-transform: capitalize;
        }
        .page-break {
            page-break-after: always;
        }
        @media print {
            body {
                margin: 0;
            }
            .document-section {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Bulk Document Print</h1>
        <p>Generated on: {{ date('F d, Y - g:i A') }}</p>
        <p>Total Documents: {{ count($documents) }}</p>
    </div>

    @foreach($documents as $index => $document)
        <div class="document-section @if($index < count($documents) - 1) page-break @endif">
            <div class="document-header">
                <h3>{{ $document->file_name }}</h3>
                <div class="document-info">
                    <div><strong>Category:</strong> <span class="badge">{{ ucfirst(str_replace('_', ' ', $document->category)) }}</span></div>
                    <div><strong>File Size:</strong> {{ $document->file_size_in_kb }}</div>
                    <div><strong>Patient:</strong> {{ $document->patient ? $document->patient->full_name : 'Unknown' }}</div>
                    <div><strong>Uploaded By:</strong> {{ $document->uploadedBy->name }}</div>
                    <div><strong>Date Uploaded:</strong> {{ $document->created_at->format('F d, Y - g:i A') }}</div>
                    <div><strong>Description:</strong> {{ $document->description ?? 'N/A' }}</div>
                </div>
            </div>

            <div class="document-content">
                @if($document->isPdf())
                    <p><em>This is a PDF document. The original file can be downloaded from the system.</em></p>
                    <p><strong>File Path:</strong> {{ $document->file_path }}</p>
                @elseif($document->isImage())
                    <p><em>This is an image document. The original file can be downloaded from the system.</em></p>
                    <p><strong>File Path:</strong> {{ $document->file_path }}</p>
                @elseif($document->isWordDocument())
                    <p><em>This is a Word document. The original file can be downloaded from the system.</em></p>
                    <p><strong>File Path:</strong> {{ $document->file_path }}</p>
                @else
                    <p><em>This is a {{ $document->file_type }} document. The original file can be downloaded from the system.</em></p>
                    <p><strong>File Path:</strong> {{ $document->file_path }}</p>
                @endif

                @if($document->description)
                    <div style="margin-top: 20px; padding: 15px; background-color: #f9f9f9; border-left: 3px solid #17a2b8;">
                        <strong>Description:</strong>
                        <p>{{ $document->description }}</p>
                    </div>
                @endif
            </div>
        </div>
    @endforeach

    <div class="footer" style="margin-top: 50px; text-align: center; color: #999; font-size: 12px;">
        <p>Document Management System - Bulk Print Report</p>
        <p>This document was generated automatically. For the original files, please access them through the system.</p>
    </div>
</body>
</html>
