<?php $__env->startSection('page-title', 'Documents Report'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-file-earmark me-2"></i>Documents Report</span>
        <a href="<?php echo e(route('reports.index')); ?>" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <strong>Total Documents:</strong> <?php echo e($documents->count()); ?>

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
                    <?php $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($document->file_name); ?></td>
                        <td><?php echo e(ucfirst(str_replace('_', ' ', $document->category))); ?></td>
                        <td>
                            <?php if($document->patient): ?>
                            <?php echo e($document->patient->full_name); ?>

                            <?php else: ?>
                            <span class="text-muted">Unknown</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($document->formatted_file_size); ?></td>
                        <td><?php echo e($document->uploadedBy->name); ?></td>
                        <td><?php echo e($document->created_at->format('M d, Y')); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\document-management-system\resources\views/reports/documents.blade.php ENDPATH**/ ?>