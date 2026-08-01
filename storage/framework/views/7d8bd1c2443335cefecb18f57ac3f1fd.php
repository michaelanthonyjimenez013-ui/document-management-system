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
        <p>Generated on: <?php echo e(date('F d, Y - g:i A')); ?></p>
        <p>Total Documents: <?php echo e(count($documents)); ?></p>
    </div>

    <?php $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="document-section <?php if($index < count($documents) - 1): ?> page-break <?php endif; ?>">
            <div class="document-header">
                <h3><?php echo e($document->file_name); ?></h3>
                <div class="document-info">
                    <div><strong>Category:</strong> <span class="badge"><?php echo e(ucfirst(str_replace('_', ' ', $document->category))); ?></span></div>
                    <div><strong>File Size:</strong> <?php echo e($document->file_size_in_kb); ?></div>
                    <div><strong>Patient:</strong> <?php echo e($document->patient ? $document->patient->full_name : 'Unknown'); ?></div>
                    <div><strong>Uploaded By:</strong> <?php echo e($document->uploadedBy->name); ?></div>
                    <div><strong>Date Uploaded:</strong> <?php echo e($document->created_at->format('F d, Y - g:i A')); ?></div>
                    <div><strong>Description:</strong> <?php echo e($document->description ?? 'N/A'); ?></div>
                </div>
            </div>

            <div class="document-content">
                <?php if($document->isPdf()): ?>
                    <p><em>This is a PDF document. The original file can be downloaded from the system.</em></p>
                    <p><strong>File Path:</strong> <?php echo e($document->file_path); ?></p>
                <?php elseif($document->isImage()): ?>
                    <p><em>This is an image document. The original file can be downloaded from the system.</em></p>
                    <p><strong>File Path:</strong> <?php echo e($document->file_path); ?></p>
                <?php elseif($document->isWordDocument()): ?>
                    <p><em>This is a Word document. The original file can be downloaded from the system.</em></p>
                    <p><strong>File Path:</strong> <?php echo e($document->file_path); ?></p>
                <?php else: ?>
                    <p><em>This is a <?php echo e($document->file_type); ?> document. The original file can be downloaded from the system.</em></p>
                    <p><strong>File Path:</strong> <?php echo e($document->file_path); ?></p>
                <?php endif; ?>

                <?php if($document->description): ?>
                    <div style="margin-top: 20px; padding: 15px; background-color: #f9f9f9; border-left: 3px solid #17a2b8;">
                        <strong>Description:</strong>
                        <p><?php echo e($document->description); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <div class="footer" style="margin-top: 50px; text-align: center; color: #999; font-size: 12px;">
        <p>Document Management System - Bulk Print Report</p>
        <p>This document was generated automatically. For the original files, please access them through the system.</p>
    </div>
</body>
</html>
<?php /**PATH C:\document-management-system\resources\views/documents/bulk-print.blade.php ENDPATH**/ ?>