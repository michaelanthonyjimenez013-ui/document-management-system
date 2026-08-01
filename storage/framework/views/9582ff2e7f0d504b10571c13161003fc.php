<?php $__env->startSection('page-title', 'Upload Document'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <i class="bi bi-upload me-2"></i>Upload Document
    </div>
    <div class="card-body">
        <form method="POST" action="<?php echo e(route('documents.upload')); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            
            <div class="mb-3">
                <label for="patient_id" class="form-label">Patient *</label>
                <select class="form-select" id="patient_id" name="patient_id" required>
                    <option value="">Select Patient</option>
                    <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($patient->id); ?>" <?php echo e(old('patient_id') == $patient->id ? 'selected' : ''); ?>>
                        <?php echo e($patient->full_name); ?> (<?php echo e($patient->health_record_number); ?>)
                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['patient_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="text-danger small"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            
            <div class="mb-3">
                <label for="assessment_id" class="form-label">Assessment (Optional)</label>
                <select class="form-select" id="assessment_id" name="assessment_id">
                    <option value="">Select Assessment</option>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="file" class="form-label">File *</label>
                <input type="file" class="form-control" id="file" name="file" required accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                <?php $__errorArgs = ['file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="text-danger small"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <small class="text-muted">Accepted formats: PDF, DOC, DOCX, JPG, JPEG, PNG (Max: 10MB)</small>
            </div>
            
            <div class="mb-3">
                <label for="category" class="form-label">Category *</label>
                <select class="form-select" id="category" name="category" required>
                    <option value="">Select Category</option>
                    <option value="mswd_assessment_form" <?php echo e(old('category') === 'mswd_assessment_form' ? 'selected' : ''); ?>>MSWD Assessment Form</option>
                    <option value="medical_certificate" <?php echo e(old('category') === 'medical_certificate' ? 'selected' : ''); ?>>Medical Certificate</option>
                    <option value="birth_certificate" <?php echo e(old('category') === 'birth_certificate' ? 'selected' : ''); ?>>Birth Certificate</option>
                    <option value="valid_id" <?php echo e(old('category') === 'valid_id' ? 'selected' : ''); ?>>Valid ID</option>
                    <option value="barangay_certificate" <?php echo e(old('category') === 'barangay_certificate' ? 'selected' : ''); ?>>Barangay Certificate</option>
                    <option value="hospital_bill" <?php echo e(old('category') === 'hospital_bill' ? 'selected' : ''); ?>>Hospital Bill</option>
                    <option value="laboratory_result" <?php echo e(old('category') === 'laboratory_result' ? 'selected' : ''); ?>>Laboratory Result</option>
                    <option value="prescription" <?php echo e(old('category') === 'prescription' ? 'selected' : ''); ?>>Prescription</option>
                    <option value="referral_letter" <?php echo e(old('category') === 'referral_letter' ? 'selected' : ''); ?>>Referral Letter</option>
                    <option value="other" <?php echo e(old('category') === 'other' ? 'selected' : ''); ?>>Other Supporting Documents</option>
                </select>
                <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="text-danger small"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"><?php echo e(old('description')); ?></textarea>
            </div>
            
            <div class="d-flex justify-content-between">
                <a href="<?php echo e(route('documents.index')); ?>" class="btn btn-secondary">
                    <i class="bi bi-x-circle me-1"></i> Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-upload me-1"></i> Upload Document
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.getElementById('patient_id').addEventListener('change', function() {
        const patientId = this.value;
        const assessmentSelect = document.getElementById('assessment_id');
        
        if (patientId) {
            fetch(`/api/patients/${patientId}/assessments`)
                .then(response => response.json())
                .then(data => {
                    assessmentSelect.innerHTML = '<option value="">Select Assessment</option>';
                    data.forEach(assessment => {
                        assessmentSelect.innerHTML += `<option value="${assessment.id}">Assessment #${assessment.id} - ${assessment.created_at}</option>`;
                    });
                });
        } else {
            assessmentSelect.innerHTML = '<option value="">Select Assessment</option>';
        }
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\document-management-system\resources\views/documents/create.blade.php ENDPATH**/ ?>