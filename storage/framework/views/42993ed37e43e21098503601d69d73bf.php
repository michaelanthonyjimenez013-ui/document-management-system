<?php $__env->startSection('page-title', 'Patients'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-people me-2"></i>Patient Management</span>
        <a href="<?php echo e(route('patients.create')); ?>" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Add Patient
        </a>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search patients..." id="searchInput">
                    <button class="btn btn-outline-secondary" type="button">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>HRN</th>
                        <th>Name</th>
                        <th>Age/Sex</th>
                        <th>Contact</th>
                        <th>Address</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($patient->health_record_number); ?></td>
                        <td>
                            <a href="<?php echo e(route('patients.show', $patient)); ?>">
                                <?php echo e($patient->full_name); ?>

                            </a>
                        </td>
                        <td><?php echo e($patient->age); ?> / <?php echo e(ucfirst($patient->sex)); ?></td>
                        <td><?php echo e($patient->mobile_number ?? $patient->phone_number ?? '-'); ?></td>
                        <td><?php echo e($patient->barangay); ?>, <?php echo e($patient->city_municipality); ?></td>
                        <td>
                            <span class="badge bg-<?php echo e($patient->status === 'active' ? 'success' : 'secondary'); ?>">
                                <?php echo e(ucfirst($patient->status)); ?>

                            </span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="<?php echo e(route('patients.show', $patient)); ?>" class="btn btn-outline-primary" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="<?php echo e(route('patients.edit', $patient)); ?>" class="btn btn-outline-secondary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <?php if(auth()->user()->canDeletePatients()): ?>
                                <form action="<?php echo e(route('patients.destroy', $patient)); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-outline-danger" title="Delete" onclick="return confirm('Are you sure?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        
        <?php echo e($patients->links('pagination::bootstrap-5')); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\document-management-system\resources\views/patients/index.blade.php ENDPATH**/ ?>