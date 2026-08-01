@extends('layouts.app')

@section('page-title', 'Add Patient')

@section('content')
<div class="card">
    <div class="card-header">
        <i class="bi bi-person-plus me-2"></i>Register New Patient
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('patients.store') }}">
            @csrf
            
            
            <h5 class="mb-3">Personal Information</h5>
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="health_record_number" class="form-label">Health Record Number *</label>
                        <input type="text" class="form-control" id="health_record_number" name="health_record_number" value="{{ old('health_record_number') }}" required>
                        @error('health_record_number')
                        <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="mswd_number" class="form-label">MSWD Number</label>
                        <input type="text" class="form-control" id="mswd_number" name="mswd_number" value="{{ old('mswd_number') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="first_name" class="form-label">First Name *</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                        @error('first_name')
                        <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="middle_name" class="form-label">Middle Name</label>
                        <input type="text" class="form-control" id="middle_name" name="middle_name" value="{{ old('middle_name') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name *</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                        @error('last_name')
                        <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="suffix" class="form-label">Suffix</label>
                        <input type="text" class="form-control" id="suffix" name="suffix" value="{{ old('suffix') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="birth_date" class="form-label">Birth Date *</label>
                        <input type="date" class="form-control" id="birth_date" name="birth_date" value="{{ old('birth_date') }}" required>
                        @error('birth_date')
                        <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="age" class="form-label">Age *</label>
                        <input type="text" class="form-control" id="age" name="age" value="{{ old('age') }}" required>
                        @error('age')
                        <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="sex" class="form-label">Sex *</label>
                        <select class="form-select" id="sex" name="sex" required>
                            <option value="">Select Sex</option>
                            <option value="male" {{ old('sex') === 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('sex') === 'female' ? 'selected' : '' }}>Female</option>
                        </select>
                        @error('sex')
                        <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="civil_status" class="form-label">Civil Status *</label>
                        <select class="form-select" id="civil_status" name="civil_status" required>
                            <option value="">Select Status</option>
                            <option value="single" {{ old('civil_status') === 'single' ? 'selected' : '' }}>Single</option>
                            <option value="married" {{ old('civil_status') === 'married' ? 'selected' : '' }}>Married</option>
                            <option value="widowed" {{ old('civil_status') === 'widowed' ? 'selected' : '' }}>Widowed</option>
                            <option value="separated" {{ old('civil_status') === 'separated' ? 'selected' : '' }}>Separated</option>
                            <option value="divorced" {{ old('civil_status') === 'divorced' ? 'selected' : '' }}>Divorced</option>
                        </select>
                        @error('civil_status')
                        <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="place_of_birth" class="form-label">Place of Birth *</label>
                        <input type="text" class="form-control" id="place_of_birth" name="place_of_birth" value="{{ old('place_of_birth') }}" required>
                        @error('place_of_birth')
                        <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="nationality" class="form-label">Nationality *</label>
                        <input type="text" class="form-control" id="nationality" name="nationality" value="{{ old('nationality', 'Filipino') }}" required>
                        @error('nationality')
                        <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="religion" class="form-label">Religion</label>
                        <input type="text" class="form-control" id="religion" name="religion" value="{{ old('religion') }}">
                    </div>
                </div>
            </div>
            
            <!-- Guardian Information -->
            <h5 class="mb-3">Guardian Information</h5>
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="guardian_name" class="form-label">Guardian Name</label>
                        <input type="text" class="form-control" id="guardian_name" name="guardian_name" value="{{ old('guardian_name') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="guardian_relationship" class="form-label">Relationship</label>
                        <input type="text" class="form-control" id="guardian_relationship" name="guardian_relationship" value="{{ old('guardian_relationship') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="guardian_contact" class="form-label">Guardian Contact</label>
                        <input type="text" class="form-control" id="guardian_contact" name="guardian_contact" value="{{ old('guardian_contact') }}">
                    </div>
                </div>
            </div>
            
            
            <h5 class="mb-3">Contact Details</h5>
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="mobile_number" class="form-label">Mobile Number</label>
                        <input type="text" class="form-control" id="mobile_number" name="mobile_number" value="{{ old('mobile_number') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                        @error('email')
                        <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            
            <h5 class="mb-3">Address</h5>
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="house_number" class="form-label">House Number</label>
                        <input type="text" class="form-control" id="house_number" name="house_number" value="{{ old('house_number') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="street" class="form-label">Street</label>
                        <input type="text" class="form-control" id="street" name="street" value="{{ old('street') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="barangay" class="form-label">Barangay *</label>
                        <input type="text" class="form-control" id="barangay" name="barangay" value="{{ old('barangay') }}" required>
                        @error('barangay')
                        <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="city_municipality" class="form-label">City/Municipality *</label>
                        <input type="text" class="form-control" id="city_municipality" name="city_municipality" value="{{ old('city_municipality') }}" required>
                        @error('city_municipality')
                        <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="province" class="form-label">Province *</label>
                        <input type="text" class="form-control" id="province" name="province" value="{{ old('province') }}" required>
                        @error('province')
                        <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="zip_code" class="form-label">ZIP Code</label>
                        <input type="text" class="form-control" id="zip_code" name="zip_code" value="{{ old('zip_code') }}">
                    </div>
                </div>
            </div>
            
            <div class="d-flex justify-content-between">
                <a href="{{ route('patients.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle me-1"></i> Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-1"></i> Save Patient
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
