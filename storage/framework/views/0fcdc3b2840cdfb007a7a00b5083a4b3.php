<?php $__env->startSection('page-title', 'User Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-person-gear me-2"></i>User Management</span>
        <a href="<?php echo e(route('register')); ?>" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Add User
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($user->name); ?></td>
                        <td><?php echo e($user->email); ?></td>
                        <td>
                            <span class="badge bg-<?php echo e($user->role === 'administrator' ? 'danger' : ($user->role === 'medical_social_worker' ? 'primary' : 'secondary')); ?>">
                                <?php echo e(ucfirst(str_replace('_', ' ', $user->role))); ?>

                            </span>
                        </td>
                        <td>
                            <?php if($user->is_active): ?>
                            <span class="badge bg-success">Active</span>
                            <?php else: ?>
                            <span class="badge bg-secondary">Inactive</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($user->created_at->format('M d, Y')); ?></td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="<?php echo e(route('users.show', $user)); ?>" class="btn btn-outline-primary" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="<?php echo e(route('users.edit', $user)); ?>" class="btn btn-outline-secondary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <?php if($user->id !== auth()->id()): ?>
                                <form action="<?php echo e(route('users.destroy', $user)); ?>" method="POST" class="d-inline">
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
        
        <?php echo e($users->links('pagination::bootstrap-5')); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\document-management-system\resources\views/users/index.blade.php ENDPATH**/ ?>