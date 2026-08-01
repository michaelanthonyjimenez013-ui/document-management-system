<?php $__env->startSection('page-title', 'Patient Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-8">
        <!-- Patient Information -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-person me-2"></i>Patient Information</span>
                <div class="btn-group btn-group-sm">
                    <a href="<?php echo e(route('patients.edit', $patient)); ?>" class="btn btn-outline-primary">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <a href="<?php echo e(route('patients.assessments.create', $patient)); ?>" class="btn btn-outline-success">
                        <i class="bi bi-clipboard-plus"></i> New Assessment
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td class="fw-bold">Health Record Number:</td>
                                <td><?php echo e($patient->health_record_number); ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">MSWD Number:</td>
                                <td><?php echo e($patient->mswd_number ?? 'N/A'); ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Full Name:</td>
                                <td><?php echo e($patient->full_name); ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Birth Date:</td>
                                <td><?php echo e($patient->birth_date->format('F d, Y')); ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Age:</td>
                                <td><?php echo e($patient->age); ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Sex:</td>
                                <td><?php echo e(ucfirst($patient->sex)); ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Civil Status:</td>
                                <td><?php echo e(ucfirst($patient->civil_status)); ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Place of Birth:</td>
                                <td><?php echo e($patient->place_of_birth); ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Nationality:</td>
                                <td><?php echo e($patient->nationality); ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Religion:</td>
                                <td><?php echo e($patient->religion ?? 'N/A'); ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td class="fw-bold">Guardian Name:</td>
                                <td><?php echo e($patient->guardian_name ?? 'N/A'); ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Guardian Relationship:</td>
                                <td><?php echo e($patient->guardian_relationship ?? 'N/A'); ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Guardian Contact:</td>
                                <td><?php echo e($patient->guardian_contact ?? 'N/A'); ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Phone Number:</td>
                                <td><?php echo e($patient->phone_number ?? 'N/A'); ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Mobile Number:</td>
                                <td><?php echo e($patient->mobile_number ?? 'N/A'); ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Email:</td>
                                <td><?php echo e($patient->email ?? 'N/A'); ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Address:</td>
                                <td><?php echo e($patient->full_address); ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Status:</td>
                                <td>
                                    <span class="badge bg-<?php echo e($patient->status === 'active' ? 'success' : 'secondary'); ?>">
                                        <?php echo e(ucfirst($patient->status)); ?>

                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Assessments -->
        <div class="card mt-4">
            <div class="card-header">
                <i class="bi bi-clipboard-data me-2"></i>Assessments (<?php echo e($patient->assessments->count()); ?>)
            </div>
            <div class="card-body">
                <?php if($patient->assessments->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Classification</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $patient->assessments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assessment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($assessment->created_at->format('M d, Y')); ?></td>
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
                                <td>
                                    <a href="<?php echo e(route('assessments.show', $assessment)); ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="text-center text-muted py-4">
                    <i class="bi bi-clipboard-x fs-1"></i>
                    <p class="mt-2">No assessments yet</p>
                    <a href="<?php echo e(route('patients.assessments.create', $patient)); ?>" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> Create Assessment
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Documents -->
        <div class="card mt-4">
            <div class="card-header">
                <i class="bi bi-file-earmark me-2"></i>Documents (<?php echo e($patient->documents->count()); ?>)
            </div>
            <div class="card-body">
                <?php if($patient->documents->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>File Name</th>
                                <th>Category</th>
                                <th>Uploaded By</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $patient->documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <i class="bi bi-file-earmark me-1"></i>
                                    <?php echo e($document->file_name); ?>

                                </td>
                                <td><?php echo e(ucfirst(str_replace('_', ' ', $document->category))); ?></td>
                                <td><?php echo e($document->uploadedBy->name); ?></td>
                                <td><?php echo e($document->created_at->format('M d, Y')); ?></td>
                                <td>
                                    <a href="<?php echo e(route('documents.download', $document)); ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-download"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="text-center text-muted py-4">
                    <i class="bi bi-file-earmark-x fs-3"></i>
                    <p class="mt-2">No documents uploaded yet</p>
                    <a href="<?php echo e(route('documents.create')); ?>?patient_id=<?php echo e($patient->id); ?>" class="btn btn-primary btn-sm">
                        <i class="bi bi-upload me-1"></i> Upload Document
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <i class="bi bi-lightning me-2"></i>Quick Actions
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="<?php echo e(route('patients.assessments.create', $patient)); ?>" class="btn btn-primary">
                        <i class="bi bi-clipboard-plus me-2"></i>New Assessment
                    </a>
                    <a href="<?php echo e(route('documents.create')); ?>?patient_id=<?php echo e($patient->id); ?>" class="btn btn-success">
                        <i class="bi bi-upload me-2"></i>Upload Document
                    </a>
                    <a href="<?php echo e(route('export.patient', $patient)); ?>" class="btn btn-info">
                        <i class="bi bi-file-earmark-excel me-2"></i>Export to Excel
                    </a>
                    <?php if($patient->status === 'active'): ?>
                    <a href="<?php echo e(route('patients.archive', $patient)); ?>" class="btn btn-warning" onclick="return confirm('Archive this patient?')">
                        <i class="bi bi-archive me-2"></i>Archive Patient
                    </a>
                    <?php else: ?>
                    <a href="<?php echo e(route('patients.restore', $patient)); ?>" class="btn btn-success" onclick="return confirm('Restore this patient?')">
                        <i class="bi bi-arrow-counterclockwise me-2"></i>Restore Patient
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Patient Statistics -->
        <div class="card mt-4">
            <div class="card-header">
                <i class="bi bi-graph-up me-2"></i>Statistics
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6 mb-3">
                        <div class="h4"><?php echo e($patient->assessments->count()); ?></div>
                        <small class="text-muted">Assessments</small>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="h4"><?php echo e($patient->documents->count()); ?></div>
                        <small class="text-muted">Documents</small>
                    </div>
                    <div class="col-6">
                        <div class="h4"><?php echo e($patient->assessments->where('status', 'completed')->count()); ?></div>
                        <small class="text-muted">Completed</small>
                    </div>
                    <div class="col-6">
                        <div class="h4"><?php echo e($patient->assessments->where('status', 'draft')->count()); ?></div>
                        <small class="text-muted">Pending</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\document-management-system\resources\views/patients/show.blade.php ENDPATH**/ ?>