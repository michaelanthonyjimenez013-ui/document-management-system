<?php $__env->startSection('page-title', 'Assessments'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-clipboard-data me-2"></i>Assessment Management</span>
        <a href="<?php echo e(route('assessments.create')); ?>" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Create Assessment
        </a>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-4">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search assessments..." id="searchInput">
                    <button class="btn btn-outline-secondary" type="button">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-3">
                <select class="form-select" id="statusFilter">
                    <option value="">All Status</option>
                    <option value="draft">Draft</option>
                    <option value="submitted">Submitted</option>
                    <option value="completed">Completed</option>
                </select>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Patient</th>
                        <th>Status</th>
                        <th>Classification</th>
                        <th>Date Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $assessments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assessment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <?php if($assessment->patient): ?>
                            <a href="<?php echo e(route('patients.show', $assessment->patient)); ?>">
                                <?php echo e($assessment->patient->full_name); ?>

                            </a>
                            <?php else: ?>
                            <span class="text-muted">Unknown Patient</span>
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
                        <td><?php echo e($assessment->created_at->format('M d, Y')); ?></td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="<?php echo e(route('assessments.show', $assessment)); ?>" class="btn btn-outline-primary" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <?php if($assessment->status === 'draft'): ?>
                                <a href="<?php echo e(route('assessments.edit', $assessment)); ?>" class="btn btn-outline-secondary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="<?php echo e(route('assessments.submit', $assessment)); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-outline-info" title="Submit" onclick="return confirm('Submit this assessment?')">
                                        <i class="bi bi-send"></i>
                                    </button>
                                </form>
                                <?php elseif($assessment->status === 'submitted'): ?>
                                <form action="<?php echo e(route('assessments.complete', $assessment)); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-outline-success" title="Complete" onclick="return confirm('Mark as completed?')">
                                        <i class="bi bi-check-circle"></i>
                                    </button>
                                </form>
                                <?php endif; ?>
                                <a href="<?php echo e(route('export.assessment', $assessment)); ?>" class="btn btn-outline-dark" title="Export PDF">
                                    <i class="bi bi-file-earmark-pdf"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        
        <?php echo e($assessments->links('pagination::bootstrap-5')); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\document-management-system\resources\views/assessments/index.blade.php ENDPATH**/ ?>