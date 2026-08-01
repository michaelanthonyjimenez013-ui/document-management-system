<?php $__env->startSection('page-title', 'Import'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-file-earmark-excel me-2"></i>Import Patients from Excel
            </div>
            <div class="card-body">
                <form method="POST" action="<?php echo e(route('import.patients')); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="mb-3">
                        <label for="patient_file" class="form-label">Excel File</label>
                        <input type="file" class="form-control" id="patient_file" name="file" accept=".xlsx,.xls,.csv" required>
                        <small class="text-muted">Accepted formats: XLSX, XLS, CSV</small>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-upload me-1"></i> Import Patients
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-file-earmark me-2"></i>Bulk Document Upload
            </div>
            <div class="card-body">
                <form method="POST" action="<?php echo e(route('import.documents')); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="mb-3">
                        <label for="import_patient_id" class="form-label">Patient</label>
                        <select class="form-select" id="import_patient_id" name="patient_id" required>
                            <option value="">Select Patient</option>
                            <?php $__currentLoopData = $patients ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($patient->id); ?>"><?php echo e($patient->full_name); ?> (<?php echo e($patient->health_record_number); ?>)</option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="import_category" class="form-label">Category</label>
                        <select class="form-select" id="import_category" name="category" required>
                            <option value="">Select Category</option>
                            <option value="mswd_assessment_form">MSWD Assessment Form</option>
                            <option value="medical_certificate">Medical Certificate</option>
                            <option value="birth_certificate">Birth Certificate</option>
                            <option value="valid_id">Valid ID</option>
                            <option value="barangay_certificate">Barangay Certificate</option>
                            <option value="hospital_bill">Hospital Bill</option>
                            <option value="laboratory_result">Laboratory Result</option>
                            <option value="prescription">Prescription</option>
                            <option value="referral_letter">Referral Letter</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="document_files" class="form-label">Files</label>
                        <input type="file" class="form-control" id="document_files" name="files[]" multiple accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required>
                        <small class="text-muted">Accepted formats: PDF, DOC, DOCX, JPG, PNG</small>
                    </div>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-upload me-1"></i> Upload Documents
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-info-circle me-2"></i>Import Guidelines
            </div>
            <div class="card-body">
                <h6>Patient Import Format</h6>
                <p>Excel file should contain the following columns:</p>
                <ul>
                    <li>health_record_number (required)</li>
                    <li>first_name (required)</li>
                    <li>last_name (required)</li>
                    <li>middle_name</li>
                    <li>birth_date (required, YYYY-MM-DD)</li>
                    <li>age (required)</li>
                    <li>sex (required: male/female)</li>
                    <li>civil_status (required: single/married/widowed/separated/divorced)</li>
                    <li>place_of_birth (required)</li>
                    <li>nationality (required)</li>
                    <li>barangay (required)</li>
                    <li>city_municipality (required)</li>
                    <li>province (required)</li>
                    <li>mobile_number</li>
                    <li>email</li>
                </ul>
                <hr>
                <h6>Document Upload</h6>
                <p>Multiple files can be uploaded at once. Duplicate files (same name for same patient) will be skipped.</p>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\document-management-system\resources\views/import/index.blade.php ENDPATH**/ ?>