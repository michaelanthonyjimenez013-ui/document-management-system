<?php $__env->startSection('page-title', 'Search'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <i class="bi bi-search me-2"></i>Search Records
    </div>
    <div class="card-body">
        <form method="GET" action="<?php echo e(route('search')); ?>">
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" placeholder="Search by name, HRN, MSWD number, or document name..." value="<?php echo e($query ?? ''); ?>">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i> Search
                        </button>
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="type">
                        <option value="all" <?php echo e($type === 'all' ? 'selected' : ''); ?>>All Records</option>
                        <option value="patients" <?php echo e($type === 'patients' ? 'selected' : ''); ?>>Patients Only</option>
                        <option value="assessments" <?php echo e($type === 'assessments' ? 'selected' : ''); ?>>Assessments Only</option>
                        <option value="documents" <?php echo e($type === 'documents' ? 'selected' : ''); ?>>Documents Only</option>
                    </select>
                </div>
            </div>
        </form>
        
        <?php if(isset($query)): ?>
        <div class="row mt-4">
            <?php if($patients->count() > 0): ?>
            <div class="col-12 mb-4">
                <h5><i class="bi bi-people me-2"></i>Patients (<?php echo e($patients->count()); ?>)</h5>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>HRN</th>
                                <th>Name</th>
                                <th>Age/Sex</th>
                                <th>Contact</th>
                                <th>Address</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($patient->health_record_number); ?></td>
                                <td><?php echo e($patient->full_name); ?></td>
                                <td><?php echo e($patient->age); ?> / <?php echo e(ucfirst($patient->sex)); ?></td>
                                <td><?php echo e($patient->mobile_number ?? $patient->phone_number ?? '-'); ?></td>
                                <td><?php echo e($patient->barangay); ?>, <?php echo e($patient->city_municipality); ?></td>
                                <td>
                                    <a href="<?php echo e(route('patients.show', $patient)); ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>
            
            <?php if($assessments->count() > 0): ?>
            <div class="col-12 mb-4">
                <h5><i class="bi bi-clipboard-data me-2"></i>Assessments (<?php echo e($assessments->count()); ?>)</h5>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Patient</th>
                                <th>Status</th>
                                <th>Classification</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $assessments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assessment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
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
                                <td><?php echo e($assessment->created_at->format('M d, Y')); ?></td>
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
            </div>
            <?php endif; ?>
            
            <?php if($documents->count() > 0): ?>
            <div class="col-12 mb-4">
                <h5><i class="bi bi-file-earmark me-2"></i>Documents (<?php echo e($documents->count()); ?>)</h5>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>File Name</th>
                                <th>Category</th>
                                <th>Patient</th>
                                <th>Date</th>
                                <th>Actions</th>
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
                                <td><?php echo e($document->created_at->format('M d, Y')); ?></td>
                                <td>
                                    <a href="<?php echo e(route('documents.download', $document)); ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-download"></i> Download
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>
            
            <?php if($patients->count() === 0 && $assessments->count() === 0 && $documents->count() === 0): ?>
            <div class="col-12">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    No results found for "<?php echo e($query); ?>"
                </div>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\document-management-system\resources\views/search/index.blade.php ENDPATH**/ ?>