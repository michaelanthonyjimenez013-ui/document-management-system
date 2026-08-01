<?php $__env->startSection('page-title', 'Assessments Report'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-clipboard-data me-2"></i>Assessments Report</span>
        <a href="<?php echo e(route('reports.index')); ?>" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <strong>Total Assessments:</strong> <?php echo e($assessments->count()); ?>

        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Patient</th>
                        <th>Status</th>
                        <th>Classification</th>
                        <th>Created By</th>
                        <th>Date Created</th>
                        <th>Submitted</th>
                        <th>Completed</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $assessments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assessment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>#<?php echo e($assessment->id); ?></td>
                        <td>
                            <?php if($assessment->patient): ?>
                            <?php echo e($assessment->patient->full_name); ?>

                            <?php else: ?>
                            <span class="text-muted">Unknown</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($assessment->status === 'draft'): ?>
                            <span class="badge bg-warning">Draft</span>
                            <?php elseif($assessment->status === 'submitted'): ?>
                            <span class="badge bg-info">Submitted</span>
                            <?php elseif($assessment->status === 'completed'): ?>
                            <span class="badge bg-success">Completed</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($assessment->classification ? strtoupper($assessment->classification) : 'N/A'); ?></td>
                        <td><?php echo e($assessment->createdBy->name); ?></td>
                        <td><?php echo e($assessment->created_at->format('M d, Y')); ?></td>
                        <td><?php echo e($assessment->submitted_at ? $assessment->submitted_at->format('M d, Y') : 'N/A'); ?></td>
                        <td><?php echo e($assessment->completed_at ? $assessment->completed_at->format('M d, Y') : 'N/A'); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\document-management-system\resources\views/reports/assessments.blade.php ENDPATH**/ ?>