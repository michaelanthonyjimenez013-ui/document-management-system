<?php $__env->startSection('page-title', 'Create Assessment'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <i class="bi bi-clipboard-plus me-2"></i>Create MSWD Assessment
    </div>
    <div class="card-body">
        <form method="POST" action="<?php echo e(route('assessments.store')); ?>">
            <?php echo csrf_field(); ?>
            
            <div class="mb-3">
                <label for="patient_id" class="form-label">Patient *</label>
                <select class="form-select" id="patient_id" name="patient_id" required>
                    <option value="">Select Patient</option>
                    <?php if(isset($patient)): ?>
                    <option value="<?php echo e($patient->id); ?>" selected><?php echo e($patient->full_name); ?> (<?php echo e($patient->health_record_number); ?>)</option>
                    <?php else: ?>
                    <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patientOption): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($patientOption->id); ?>"><?php echo e($patientOption->full_name); ?> (<?php echo e($patientOption->health_record_number); ?>)</option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
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
            
            <!-- Demographic Information -->
            <h5 class="mb-3 mt-4">Demographic Information</h5>
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="father_name" class="form-label">Father's Name</label>
                        <input type="text" class="form-control" id="father_name" name="father_name" value="<?php echo e(old('father_name')); ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="father_occupation" class="form-label">Father's Occupation</label>
                        <input type="text" class="form-control" id="father_occupation" name="father_occupation" value="<?php echo e(old('father_occupation')); ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="mother_name" class="form-label">Mother's Name</label>
                        <input type="text" class="form-control" id="mother_name" name="mother_name" value="<?php echo e(old('mother_name')); ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="mother_occupation" class="form-label">Mother's Occupation</label>
                        <input type="text" class="form-control" id="mother_occupation" name="mother_occupation" value="<?php echo e(old('mother_occupation')); ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="family_members" class="form-label">Family Members</label>
                        <input type="number" class="form-control" id="family_members" name="family_members" value="<?php echo e(old('family_members')); ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="siblings" class="form-label">Siblings</label>
                        <input type="number" class="form-control" id="siblings" name="siblings" value="<?php echo e(old('siblings')); ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="birth_order" class="form-label">Birth Order</label>
                        <input type="number" class="form-control" id="birth_order" name="birth_order" value="<?php echo e(old('birth_order')); ?>">
                    </div>
                </div>
            </div>
            
            <!-- Family Information -->
            <h5 class="mb-3 mt-4">Family Information</h5>
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="family_composition" class="form-label">Family Composition</label>
                        <textarea class="form-control" id="family_composition" name="family_composition" rows="3"><?php echo e(old('family_composition')); ?></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="family_income_source" class="form-label">Family Income Source</label>
                        <textarea class="form-control" id="family_income_source" name="family_income_source" rows="3"><?php echo e(old('family_income_source')); ?></textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="monthly_income" class="form-label">Monthly Income (PHP)</label>
                        <input type="number" step="0.01" class="form-control" id="monthly_income" name="monthly_income" value="<?php echo e(old('monthly_income')); ?>">
                    </div>
                </div>
            </div>
            
            <!-- MSWD Classification -->
            <h5 class="mb-3 mt-4">MSWD Classification</h5>
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="classification" class="form-label">Classification</label>
                        <select class="form-select" id="classification" name="classification">
                            <option value="">Select Classification</option>
                            <option value="a" <?php echo e(old('classification') === 'a' ? 'selected' : ''); ?>>A (High Income)</option>
                            <option value="b" <?php echo e(old('classification') === 'b' ? 'selected' : ''); ?>>B (Middle Income)</option>
                            <option value="c" <?php echo e(old('classification') === 'c' ? 'selected' : ''); ?>>C (Low Income)</option>
                            <option value="d" <?php echo e(old('classification') === 'd' ? 'selected' : ''); ?>>D (No Income)</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="mb-3">
                        <label for="classification_remarks" class="form-label">Classification Remarks</label>
                        <textarea class="form-control" id="classification_remarks" name="classification_remarks" rows="2"><?php echo e(old('classification_remarks')); ?></textarea>
                    </div>
                </div>
            </div>
            
            <!-- Medical History -->
            <h5 class="mb-3 mt-4">Medical History</h5>
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="medical_history" class="form-label">Medical History</label>
                        <textarea class="form-control" id="medical_history" name="medical_history" rows="3"><?php echo e(old('medical_history')); ?></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="current_diagnosis" class="form-label">Current Diagnosis</label>
                        <textarea class="form-control" id="current_diagnosis" name="current_diagnosis" rows="3"><?php echo e(old('current_diagnosis')); ?></textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="hospital_name" class="form-label">Hospital Name</label>
                        <input type="text" class="form-control" id="hospital_name" name="hospital_name" value="<?php echo e(old('hospital_name')); ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="admission_date" class="form-label">Admission Date</label>
                        <input type="date" class="form-control" id="admission_date" name="admission_date" value="<?php echo e(old('admission_date')); ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="discharge_date" class="form-label">Discharge Date</label>
                        <input type="date" class="form-control" id="discharge_date" name="discharge_date" value="<?php echo e(old('discharge_date')); ?>">
                    </div>
                </div>
            </div>
            
            <!-- Monthly Expenses -->
            <h5 class="mb-3 mt-4">Monthly Expenses (PHP)</h5>
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="food_expenses" class="form-label">Food</label>
                        <input type="number" step="0.01" class="form-control" id="food_expenses" name="food_expenses" value="<?php echo e(old('food_expenses')); ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="rent_expenses" class="form-label">Rent</label>
                        <input type="number" step="0.01" class="form-control" id="rent_expenses" name="rent_expenses" value="<?php echo e(old('rent_expenses')); ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="utilities_expenses" class="form-label">Utilities</label>
                        <input type="number" step="0.01" class="form-control" id="utilities_expenses" name="utilities_expenses" value="<?php echo e(old('utilities_expenses')); ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="transportation_expenses" class="form-label">Transportation</label>
                        <input type="number" step="0.01" class="form-control" id="transportation_expenses" name="transportation_expenses" value="<?php echo e(old('transportation_expenses')); ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="medical_expenses" class="form-label">Medical</label>
                        <input type="number" step="0.01" class="form-control" id="medical_expenses" name="medical_expenses" value="<?php echo e(old('medical_expenses')); ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="education_expenses" class="form-label">Education</label>
                        <input type="number" step="0.01" class="form-control" id="education_expenses" name="education_expenses" value="<?php echo e(old('education_expenses')); ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="other_expenses" class="form-label">Other</label>
                        <input type="number" step="0.01" class="form-control" id="other_expenses" name="other_expenses" value="<?php echo e(old('other_expenses')); ?>">
                    </div>
                </div>
            </div>
            
            <!-- Presenting Problems -->
            <h5 class="mb-3 mt-4">Presenting Problems</h5>
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="presenting_problems" class="form-label">Presenting Problems</label>
                        <textarea class="form-control" id="presenting_problems" name="presenting_problems" rows="3"><?php echo e(old('presenting_problems')); ?></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="client_concerns" class="form-label">Client Concerns</label>
                        <textarea class="form-control" id="client_concerns" name="client_concerns" rows="3"><?php echo e(old('client_concerns')); ?></textarea>
                    </div>
                </div>
            </div>
            
            <!-- Housing Information -->
            <h5 class="mb-3 mt-4">Housing Information</h5>
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="housing_type" class="form-label">Housing Type</label>
                        <select class="form-select" id="housing_type" name="housing_type">
                            <option value="">Select Type</option>
                            <option value="owned" <?php echo e(old('housing_type') === 'owned' ? 'selected' : ''); ?>>Owned</option>
                            <option value="rented" <?php echo e(old('housing_type') === 'rented' ? 'selected' : ''); ?>>Rented</option>
                            <option value="shared" <?php echo e(old('housing_type') === 'shared' ? 'selected' : ''); ?>>Shared</option>
                            <option value="informal_settler" <?php echo e(old('housing_type') === 'informal_settler' ? 'selected' : ''); ?>>Informal Settler</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="water_source" class="form-label">Water Source</label>
                        <select class="form-select" id="water_source" name="water_source">
                            <option value="">Select Source</option>
                            <option value="piped" <?php echo e(old('water_source') === 'piped' ? 'selected' : ''); ?>>Piped</option>
                            <option value="well" <?php echo e(old('water_source') === 'well' ? 'selected' : ''); ?>>Well</option>
                            <option value="spring" <?php echo e(old('water_source') === 'spring' ? 'selected' : ''); ?>>Spring</option>
                            <option value="others" <?php echo e(old('water_source') === 'others' ? 'selected' : ''); ?>>Others</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="sanitation_type" class="form-label">Sanitation Type</label>
                        <select class="form-select" id="sanitation_type" name="sanitation_type">
                            <option value="">Select Type</option>
                            <option value="sewered" <?php echo e(old('sanitation_type') === 'sewered' ? 'selected' : ''); ?>>Sewered</option>
                            <option value="septic_tank" <?php echo e(old('sanitation_type') === 'septic_tank' ? 'selected' : ''); ?>>Septic Tank</option>
                            <option value="open_pit" <?php echo e(old('sanitation_type') === 'open_pit' ? 'selected' : ''); ?>>Open Pit</option>
                            <option value="others" <?php echo e(old('sanitation_type') === 'others' ? 'selected' : ''); ?>>Others</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="housing_condition" class="form-label">Housing Condition</label>
                        <textarea class="form-control" id="housing_condition" name="housing_condition" rows="2"><?php echo e(old('housing_condition')); ?></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="electricity" class="form-label">Electricity</label>
                        <select class="form-select" id="electricity" name="electricity">
                            <option value="">Select</option>
                            <option value="available" <?php echo e(old('electricity') === 'available' ? 'selected' : ''); ?>>Available</option>
                            <option value="not_available" <?php echo e(old('electricity') === 'not_available' ? 'selected' : ''); ?>>Not Available</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <!-- Education -->
            <h5 class="mb-3 mt-4">Education</h5>
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="education_level" class="form-label">Education Level</label>
                        <select class="form-select" id="education_level" name="education_level">
                            <option value="">Select Level</option>
                            <option value="none" <?php echo e(old('education_level') === 'none' ? 'selected' : ''); ?>>None</option>
                            <option value="elementary" <?php echo e(old('education_level') === 'elementary' ? 'selected' : ''); ?>>Elementary</option>
                            <option value="high_school" <?php echo e(old('education_level') === 'high_school' ? 'selected' : ''); ?>>High School</option>
                            <option value="college" <?php echo e(old('education_level') === 'college' ? 'selected' : ''); ?>>College</option>
                            <option value="vocational" <?php echo e(old('education_level') === 'vocational' ? 'selected' : ''); ?>>Vocational</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="school_name" class="form-label">School Name</label>
                        <input type="text" class="form-control" id="school_name" name="school_name" value="<?php echo e(old('school_name')); ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="currently_enrolled" class="form-label">Currently Enrolled</label>
                        <select class="form-select" id="currently_enrolled" name="currently_enrolled">
                            <option value="">Select</option>
                            <option value="1" <?php echo e(old('currently_enrolled') === '1' ? 'selected' : ''); ?>>Yes</option>
                            <option value="0" <?php echo e(old('currently_enrolled') === '0' ? 'selected' : ''); ?>>No</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <!-- Current Needs & Assessment -->
            <h5 class="mb-3 mt-4">Current Needs & Assessment</h5>
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="current_needs" class="form-label">Current Needs</label>
                        <textarea class="form-control" id="current_needs" name="current_needs" rows="3"><?php echo e(old('current_needs')); ?></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="intervention_provided" class="form-label">Intervention Provided</label>
                        <textarea class="form-control" id="intervention_provided" name="intervention_provided" rows="3"><?php echo e(old('intervention_provided')); ?></textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="assessment_statement" class="form-label">Assessment Statement</label>
                        <textarea class="form-control" id="assessment_statement" name="assessment_statement" rows="4"><?php echo e(old('assessment_statement')); ?></textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="recommendations" class="form-label">Recommendations</label>
                        <textarea class="form-control" id="recommendations" name="recommendations" rows="4"><?php echo e(old('recommendations')); ?></textarea>
                    </div>
                </div>
            </div>
            
            <div class="d-flex justify-content-between">
                <a href="<?php echo e(route('assessments.index')); ?>" class="btn btn-secondary">
                    <i class="bi bi-x-circle me-1"></i> Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-1"></i> Save Assessment
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\document-management-system\resources\views/assessments/create.blade.php ENDPATH**/ ?>