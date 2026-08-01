<?php $__env->startSection('page-title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-4">
    <h2 class="mb-1">
        Hello, <?php echo e(auth()->user()->name); ?>!
    </h2>
    <p class="text-muted">Here's what's happening today.</p>
</div>
<div class="row">
    <!-- Statistics Cards -->
    <div class="col-md-3">
        <div class="stat-card primary">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-value"><?php echo e($totalPatients); ?></div>
                    <div class="stat-label">Total Patients</div>
                </div>
                <div class="stat-icon">
                    <i class="bi bi-people"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stat-card success">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-value"><?php echo e($activeCases); ?></div>
                    <div class="stat-label">Active Cases</div>
                </div>
                <div class="stat-icon">
                    <i class="bi bi-activity"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stat-card warning">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-value"><?php echo e($pendingAssessments); ?></div>
                    <div class="stat-label">Pending Assessments</div>
                </div>
                <div class="stat-icon">
                    <i class="bi bi-clipboard-pulse"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stat-card info">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-value"><?php echo e($totalDocuments); ?></div>
                    <div class="stat-label">Total Documents</div>
                </div>
                <div class="stat-icon">
                    <i class="bi bi-file-earmark"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <!-- Recent Patients -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-people me-2"></i>Recent Patients</span>
                <a href="<?php echo e(route('patients.index')); ?>" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                <?php if($recentPatients->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>HRN</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $recentPatients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <a href="<?php echo e(route('patients.show', $patient)); ?>">
                                        <?php echo e($patient->full_name); ?>

                                    </a>
                                </td>
                                <td><?php echo e($patient->health_record_number); ?></td>
                                <td>
                                    <span class="badge bg-success">Active</span>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="text-center text-muted py-4">
                    <i class="bi bi-inbox fs-1"></i>
                    <p class="mt-2">No patients registered yet</p>
                    <a href="<?php echo e(route('patients.create')); ?>" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> Register Patient
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Recent Assessments -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-clipboard-data me-2"></i>Recent Assessments</span>
                <a href="<?php echo e(route('assessments.index')); ?>" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                <?php if($recentAssessments->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Patient</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $recentAssessments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assessment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <?php if($assessment->patient): ?>
                                    <a href="<?php echo e(route('patients.show', $assessment->patient)); ?>">
                                        <?php echo e($assessment->patient->full_name); ?>

                                    </a>
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
                                <td><?php echo e($assessment->created_at->format('M d, Y')); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="text-center text-muted py-4">
                    <i class="bi bi-clipboard-x fs-1"></i>
                    <p class="mt-2">No assessments created yet</p>
                    <a href="<?php echo e(route('assessments.create')); ?>" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> Create Assessment
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <!-- Recent Documents -->
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-file-earmark me-2"></i>Recent Documents</span>
                <a href="<?php echo e(route('documents.index')); ?>" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                <?php if($recentDocuments->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>File Name</th>
                                <th>Category</th>
                                <th>Patient</th>
                                <th>Uploaded By</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $recentDocuments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <a href="<?php echo e(route('documents.show', $document)); ?>" class="text-decoration-none">
                                        <i class="bi bi-file-earmark me-1"></i>
                                        <?php echo e($document->file_name); ?>

                                    </a>
                                </td>
                                <td><?php echo e(ucfirst(str_replace('_', ' ', $document->category))); ?></td>
                                <td>
                                    <?php if($document->patient): ?>
                                    <a href="<?php echo e(route('patients.show', $document->patient)); ?>">
                                        <?php echo e($document->patient->full_name); ?>

                                    </a>
                                    <?php else: ?>
                                    <span class="text-muted">Unknown</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($document->uploadedBy->name); ?></td>
                                <td><?php echo e($document->created_at->format('M d, Y')); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="text-center text-muted py-4">
                    <i class="bi bi-file-earmark-x fs-1"></i>
                    <p class="mt-2">No documents uploaded yet</p>
                    <a href="<?php echo e(route('documents.create')); ?>" class="btn btn-primary btn-sm">
                        <i class="bi bi-upload me-1"></i> Upload Document
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <!-- Recent Activity -->
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-clock-history me-2"></i>Recent Activity</span>
                <a href="<?php echo e(route('audit-logs.index')); ?>" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                <?php if($recentActivities->count() > 0): ?>
                    <div class="timeline">
                        <?php $__currentLoopData = $recentActivities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="d-flex align-items-start mb-3 pb-3 border-bottom">
                                <div class="flex-shrink-0 me-3">
                                    <div class="user-avatar" style="width: 36px; height: 36px; font-size: 14px;">
                                        <?php echo e(strtoupper(substr($activity->user->name ?? 'U', 0, 1))); ?>

                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <h6 class="mb-0"><?php echo e($activity->user->name ?? 'Unknown User'); ?></h6>
                                        <small class="text-muted"><?php echo e($activity->created_at->diffForHumans()); ?></small>
                                    </div>
                                    <p class="mb-0 text-muted"><?php echo e($activity->description); ?></p>
                                    <span class="badge bg-secondary mt-1"><?php echo e(ucfirst($activity->module)); ?></span>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-inbox fs-1"></i>
                        <p class="mt-2">No recent activity</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Dashboard loaded');
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\document-management-system\resources\views/dashboard/index.blade.php ENDPATH**/ ?>