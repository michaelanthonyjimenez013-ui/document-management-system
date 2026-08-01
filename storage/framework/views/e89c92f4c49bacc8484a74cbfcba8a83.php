<?php $__env->startSection('page-title', 'Add Patient'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <i class="bi bi-person-plus me-2"></i>Register New Patient
    </div>
    <div class="card-body">
        <form method="POST" action="<?php echo e(route('patients.store')); ?>">
            <?php echo csrf_field(); ?>
            
            <!-- Personal Information -->
            <h5 class="mb-3">Personal Information</h5>
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="health_record_number" class="form-label">Health Record Number *</label>
                        <input type="text" class="form-control" id="health_record_number" name="health_record_number" value="<?php echo e(old('health_record_number')); ?>" required>
                        <?php $__errorArgs = ['health_record_number'];
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
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="mswd_number" class="form-label">MSWD Number</label>
                        <input type="text" class="form-control" id="mswd_number" name="mswd_number" value="<?php echo e(old('mswd_number')); ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="first_name" class="form-label">First Name *</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo e(old('first_name')); ?>" required>
                        <?php $__errorArgs = ['first_name'];
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
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="middle_name" class="form-label">Middle Name</label>
                        <input type="text" class="form-control" id="middle_name" name="middle_name" value="<?php echo e(old('middle_name')); ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name *</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo e(old('last_name')); ?>" required>
                        <?php $__errorArgs = ['last_name'];
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
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="suffix" class="form-label">Suffix</label>
                        <input type="text" class="form-control" id="suffix" name="suffix" value="<?php echo e(old('suffix')); ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="birth_date" class="form-label">Birth Date *</label>
                        <input type="date" class="form-control" id="birth_date" name="birth_date" value="<?php echo e(old('birth_date')); ?>" required>
                        <?php $__errorArgs = ['birth_date'];
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
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="age" class="form-label">Age *</label>
                        <input type="text" class="form-control" id="age" name="age" value="<?php echo e(old('age')); ?>" required>
                        <?php $__errorArgs = ['age'];
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
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="sex" class="form-label">Sex *</label>
                        <select class="form-select" id="sex" name="sex" required>
                            <option value="">Select Sex</option>
                            <option value="male" <?php echo e(old('sex') === 'male' ? 'selected' : ''); ?>>Male</option>
                            <option value="female" <?php echo e(old('sex') === 'female' ? 'selected' : ''); ?>>Female</option>
                        </select>
                        <?php $__errorArgs = ['sex'];
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
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="civil_status" class="form-label">Civil Status *</label>
                        <select class="form-select" id="civil_status" name="civil_status" required>
                            <option value="">Select Status</option>
                            <option value="single" <?php echo e(old('civil_status') === 'single' ? 'selected' : ''); ?>>Single</option>
                            <option value="married" <?php echo e(old('civil_status') === 'married' ? 'selected' : ''); ?>>Married</option>
                            <option value="widowed" <?php echo e(old('civil_status') === 'widowed' ? 'selected' : ''); ?>>Widowed</option>
                            <option value="separated" <?php echo e(old('civil_status') === 'separated' ? 'selected' : ''); ?>>Separated</option>
                            <option value="divorced" <?php echo e(old('civil_status') === 'divorced' ? 'selected' : ''); ?>>Divorced</option>
                        </select>
                        <?php $__errorArgs = ['civil_status'];
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
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="place_of_birth" class="form-label">Place of Birth *</label>
                        <input type="text" class="form-control" id="place_of_birth" name="place_of_birth" value="<?php echo e(old('place_of_birth')); ?>" required>
                        <?php $__errorArgs = ['place_of_birth'];
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
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="nationality" class="form-label">Nationality *</label>
                        <input type="text" class="form-control" id="nationality" name="nationality" value="<?php echo e(old('nationality', 'Filipino')); ?>" required>
                        <?php $__errorArgs = ['nationality'];
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
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="religion" class="form-label">Religion</label>
                        <input type="text" class="form-control" id="religion" name="religion" value="<?php echo e(old('religion')); ?>">
                    </div>
                </div>
            </div>
            
            <!-- Guardian Information -->
            <h5 class="mb-3">Guardian Information</h5>
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="guardian_name" class="form-label">Guardian Name</label>
                        <input type="text" class="form-control" id="guardian_name" name="guardian_name" value="<?php echo e(old('guardian_name')); ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="guardian_relationship" class="form-label">Relationship</label>
                        <input type="text" class="form-control" id="guardian_relationship" name="guardian_relationship" value="<?php echo e(old('guardian_relationship')); ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="guardian_contact" class="form-label">Guardian Contact</label>
                        <input type="text" class="form-control" id="guardian_contact" name="guardian_contact" value="<?php echo e(old('guardian_contact')); ?>">
                    </div>
                </div>
            </div>
            
            <!-- Contact Details -->
            <h5 class="mb-3">Contact Details</h5>
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php echo e(old('phone_number')); ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="mobile_number" class="form-label">Mobile Number</label>
                        <input type="text" class="form-control" id="mobile_number" name="mobile_number" value="<?php echo e(old('mobile_number')); ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo e(old('email')); ?>">
                        <?php $__errorArgs = ['email'];
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
                </div>
            </div>
            
            <!-- Address -->
            <h5 class="mb-3">Address</h5>
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="house_number" class="form-label">House Number</label>
                        <input type="text" class="form-control" id="house_number" name="house_number" value="<?php echo e(old('house_number')); ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="street" class="form-label">Street</label>
                        <input type="text" class="form-control" id="street" name="street" value="<?php echo e(old('street')); ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="barangay" class="form-label">Barangay *</label>
                        <input type="text" class="form-control" id="barangay" name="barangay" value="<?php echo e(old('barangay')); ?>" required>
                        <?php $__errorArgs = ['barangay'];
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
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="city_municipality" class="form-label">City/Municipality *</label>
                        <input type="text" class="form-control" id="city_municipality" name="city_municipality" value="<?php echo e(old('city_municipality')); ?>" required>
                        <?php $__errorArgs = ['city_municipality'];
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
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="province" class="form-label">Province *</label>
                        <input type="text" class="form-control" id="province" name="province" value="<?php echo e(old('province')); ?>" required>
                        <?php $__errorArgs = ['province'];
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
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="zip_code" class="form-label">ZIP Code</label>
                        <input type="text" class="form-control" id="zip_code" name="zip_code" value="<?php echo e(old('zip_code')); ?>">
                    </div>
                </div>
            </div>
            
            <div class="d-flex justify-content-between">
                <a href="<?php echo e(route('patients.index')); ?>" class="btn btn-secondary">
                    <i class="bi bi-x-circle me-1"></i> Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-1"></i> Save Patient
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\document-management-system\resources\views/patients/create.blade.php ENDPATH**/ ?>