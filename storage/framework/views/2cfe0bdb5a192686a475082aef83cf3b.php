<?php $__env->startSection('page-title', 'Audit Logs'); ?>

<?php $__env->startSection('content'); ?>
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
                    <?php $__currentLoopData = $auditLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($log->created_at->format('M d, Y g:i A')); ?></td>
                        <td><?php echo e($log->user->name); ?></td>
                        <td>
                            <span class="badge bg-<?php echo e($log->action === 'create' ? 'success' : ($log->action === 'update' ? 'info' : ($log->action === 'delete' ? 'danger' : 'secondary'))); ?>">
                                <?php echo e(ucfirst($log->action)); ?>

                            </span>
                        </td>
                        <td><?php echo e(ucfirst($log->module)); ?></td>
                        <td><?php echo e($log->description); ?></td>
                        <td><?php echo e($log->ip_address ?? 'N/A'); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        
        <?php echo e($auditLogs->links('pagination::bootstrap-5')); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\document-management-system\resources\views/audit-logs/index.blade.php ENDPATH**/ ?>