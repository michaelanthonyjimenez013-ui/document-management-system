<?php $__env->startSection('page-title', 'Document: ' . $document->file_name); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <i class="bi bi-file-earmark me-2"></i>
            <?php echo e($document->file_name); ?>

        </div>
        <div class="d-flex gap-2">
            <button onclick="printDocument()" class="btn btn-outline-primary btn-sm">
                <i class="bi bi-printer me-1"></i> Print
            </button>
            <a href="<?php echo e(route('documents.download', $document)); ?>" class="btn btn-primary btn-sm">
                <i class="bi bi-download me-1"></i> Download
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row mb-4 no-print">
            <div class="col-md-6">
                <p class="mb-1"><strong>Category:</strong> <?php echo e(ucfirst(str_replace('_', ' ', $document->category))); ?></p>
                <p class="mb-1"><strong>Patient:</strong> 
                    <?php if($document->patient): ?>
                    <a href="<?php echo e(route('patients.show', $document->patient)); ?>"><?php echo e($document->patient->full_name); ?></a>
                    <?php else: ?>
                    <span class="text-muted">Unknown</span>
                    <?php endif; ?>
                </p>
                <p class="mb-1"><strong>Uploaded By:</strong> <?php echo e($document->uploadedBy->name); ?></p>
                <p class="mb-1"><strong>Upload Date:</strong> <?php echo e($document->created_at->format('F d, Y h:i A')); ?></p>
                <p class="mb-1"><strong>File Size:</strong> <?php echo e($document->file_size_in_kb); ?></p>
            </div>
            <div class="col-md-6">
                <?php if($document->description): ?>
                <p><strong>Description:</strong></p>
                <p class="text-muted"><?php echo e($document->description); ?></p>
                <?php endif; ?>
            </div>
        </div>

        <div class="border rounded p-3 bg-light">
            <?php if($document->isImage()): ?>
                <img src="<?php echo e(asset('storage/' . $document->file_path)); ?>" alt="<?php echo e($document->file_name); ?>" class="img-fluid">
            <?php elseif($document->isPdf()): ?>
                <iframe src="<?php echo e(asset('storage/' . $document->file_path)); ?>" class="w-100" style="height: 800px;"></iframe>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="bi bi-file-earmark fs-1 text-muted"></i>
                    <p class="mt-3">Preview not available for this file type.</p>
                    <a href="<?php echo e(route('documents.download', $document)); ?>" class="btn btn-primary">
                        <i class="bi bi-download me-1"></i> Download to view
                    </a>
                </div>
            <?php endif; ?>
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
    <?php if($document->isPdf()): ?>
        const iframe = document.querySelector('iframe');
        if (iframe) {
            iframe.contentWindow.print();
        }
    <?php else: ?>
        window.print();
    <?php endif; ?>
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\document-management-system\resources\views/documents/show.blade.php ENDPATH**/ ?>