<?php $__env->startSection('page-title', 'Patients Report'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-people me-2"></i>Patients Report</span>
        <a href="<?php echo e(route('reports.index')); ?>" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <strong>Total Patients:</strong> <?php echo e($patients->count()); ?>

        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>HRN</th>
                        <th>MSWD Number</th>
                        <th>Name</th>
                        <th>Age/Sex</th>
                        <th>Contact</th>
                        <th>Address</th>
                        <th>Status</th>
                        <th>Registered Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($patient->health_record_number); ?></td>
                        <td><?php echo e($patient->mswd_number ?? 'N/A'); ?></td>
                        <td><?php echo e($patient->full_name); ?></td>
                        <td><?php echo e($patient->age); ?> / <?php echo e(ucfirst($patient->sex)); ?></td>
                        <td><?php echo e($patient->mobile_number ?? $patient->phone_number ?? 'N/A'); ?></td>
                        <td><?php echo e($patient->barangay); ?>, <?php echo e($patient->city_municipality); ?></td>
                        <td><?php echo e(ucfirst($patient->status)); ?></td>
                        <td><?php echo e($patient->created_at->format('M d, Y')); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\document-management-system\resources\views/reports/patients.blade.php ENDPATH**/ ?>