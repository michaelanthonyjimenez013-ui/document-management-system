-- Malasakit Program Document Management System
-- Database Schema
-- Generated from Laravel migrations
-- For shared hosting: Run this in your existing database

-- Drop tables if they exist (for clean re-installation)
DROP TABLE IF EXISTS audit_logs;
DROP TABLE IF EXISTS documents;
DROP TABLE IF EXISTS assessments;
DROP TABLE IF EXISTS patients;
DROP TABLE IF EXISTS users;

-- Users Table
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('administrator', 'medical_social_worker', 'records_officer') NOT NULL DEFAULT 'medical_social_worker',
    is_active BOOLEAN NOT NULL DEFAULT 1,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    INDEX idx_users_email (email),
    INDEX idx_users_role (role),
    INDEX idx_users_is_active (is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Patients Table
CREATE TABLE patients (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    health_record_number VARCHAR(255) NOT NULL UNIQUE,
    mswd_number VARCHAR(255) NULL UNIQUE,
    
    -- Personal Information
    first_name VARCHAR(255) NOT NULL,
    middle_name VARCHAR(255) NULL,
    last_name VARCHAR(255) NOT NULL,
    suffix VARCHAR(50) NULL,
    birth_date DATE NOT NULL,
    age VARCHAR(50) NOT NULL,
    sex ENUM('male', 'female') NOT NULL,
    civil_status ENUM('single', 'married', 'widowed', 'separated', 'divorced') NOT NULL,
    place_of_birth VARCHAR(255) NOT NULL,
    nationality VARCHAR(255) NOT NULL DEFAULT 'Filipino',
    religion VARCHAR(255) NULL,
    
    -- Guardian Information
    guardian_name VARCHAR(255) NULL,
    guardian_relationship VARCHAR(255) NULL,
    guardian_contact VARCHAR(255) NULL,
    
    -- Contact Details
    phone_number VARCHAR(255) NULL,
    mobile_number VARCHAR(255) NULL,
    email VARCHAR(255) NULL,
    
    -- Address
    house_number TEXT NULL,
    street TEXT NULL,
    barangay TEXT NOT NULL,
    city_municipality TEXT NOT NULL,
    province TEXT NOT NULL,
    zip_code VARCHAR(20) NULL,
    
    -- Status
    status ENUM('active', 'archived') NOT NULL DEFAULT 'active',
    created_by BIGINT UNSIGNED NULL,
    updated_by BIGINT UNSIGNED NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_patients_health_record_number (health_record_number),
    INDEX idx_patients_mswd_number (mswd_number),
    INDEX idx_patients_status (status),
    INDEX idx_patients_last_name (last_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Assessments Table
CREATE TABLE assessments (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    patient_id BIGINT UNSIGNED NOT NULL,
    created_by BIGINT UNSIGNED NOT NULL,
    
    -- Demographic Information
    father_name VARCHAR(255) NULL,
    father_occupation VARCHAR(255) NULL,
    mother_name VARCHAR(255) NULL,
    mother_occupation VARCHAR(255) NULL,
    family_members INT NULL,
    siblings INT NULL,
    birth_order INT NULL,
    
    -- Family Information
    family_composition TEXT NULL,
    family_income_source TEXT NULL,
    monthly_income DECIMAL(10, 2) NULL,
    
    -- MSWD Classification
    classification ENUM('a', 'b', 'c', 'd') NULL,
    classification_remarks TEXT NULL,
    
    -- Medical History
    medical_history TEXT NULL,
    current_diagnosis TEXT NULL,
    hospital_name VARCHAR(255) NULL,
    admission_date DATE NULL,
    discharge_date DATE NULL,
    
    -- Monthly Expenses
    food_expenses DECIMAL(10, 2) NULL,
    rent_expenses DECIMAL(10, 2) NULL,
    utilities_expenses DECIMAL(10, 2) NULL,
    transportation_expenses DECIMAL(10, 2) NULL,
    medical_expenses DECIMAL(10, 2) NULL,
    education_expenses DECIMAL(10, 2) NULL,
    other_expenses DECIMAL(10, 2) NULL,
    total_expenses DECIMAL(10, 2) NULL,
    
    -- Presenting Problems
    presenting_problems TEXT NULL,
    client_concerns TEXT NULL,
    
    -- Housing Information
    housing_type ENUM('owned', 'rented', 'shared', 'informal_settler') NULL,
    housing_condition TEXT NULL,
    water_source ENUM('piped', 'well', 'spring', 'others') NULL,
    sanitation_type ENUM('sewered', 'septic_tank', 'open_pit', 'others') NULL,
    electricity ENUM('available', 'not_available') NULL,
    
    -- Education
    education_level ENUM('none', 'elementary', 'high_school', 'college', 'vocational') NULL,
    school_name VARCHAR(255) NULL,
    currently_enrolled BOOLEAN NOT NULL DEFAULT 0,
    
    -- Current Needs
    current_needs TEXT NULL,
    intervention_provided TEXT NULL,
    
    -- Assessment Statement
    assessment_statement TEXT NULL,
    recommendations TEXT NULL,
    
    -- Status
    status ENUM('draft', 'submitted', 'completed') NOT NULL DEFAULT 'draft',
    submitted_at TIMESTAMP NULL,
    completed_at TIMESTAMP NULL,
    
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_assessments_patient_id (patient_id),
    INDEX idx_assessments_status (status),
    INDEX idx_assessments_classification (classification)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Documents Table
CREATE TABLE documents (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    patient_id BIGINT UNSIGNED NOT NULL,
    assessment_id BIGINT UNSIGNED NULL,
    uploaded_by BIGINT UNSIGNED NOT NULL,
    
    file_name VARCHAR(255) NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    file_type VARCHAR(50) NOT NULL,
    file_size VARCHAR(50) NOT NULL,
    mime_type VARCHAR(100) NOT NULL,
    
    category ENUM(
        'mswd_assessment_form',
        'medical_certificate',
        'birth_certificate',
        'valid_id',
        'barangay_certificate',
        'hospital_bill',
        'laboratory_result',
        'prescription',
        'referral_letter',
        'other'
    ) NOT NULL DEFAULT 'other',
    
    description TEXT NULL,
    is_archived BOOLEAN NOT NULL DEFAULT 0,
    
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE,
    FOREIGN KEY (assessment_id) REFERENCES assessments(id) ON DELETE SET NULL,
    FOREIGN KEY (uploaded_by) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_documents_patient_id (patient_id),
    INDEX idx_documents_category (category),
    INDEX idx_documents_is_archived (is_archived)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Audit Logs Table
CREATE TABLE audit_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NULL,
    
    action VARCHAR(255) NOT NULL,
    module VARCHAR(255) NOT NULL,
    description TEXT NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    
    patient_id BIGINT UNSIGNED NULL,
    assessment_id BIGINT UNSIGNED NULL,
    document_id BIGINT UNSIGNED NULL,
    
    old_values JSON NULL,
    new_values JSON NULL,
    
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE SET NULL,
    FOREIGN KEY (assessment_id) REFERENCES assessments(id) ON DELETE SET NULL,
    FOREIGN KEY (document_id) REFERENCES documents(id) ON DELETE SET NULL,
    INDEX idx_audit_logs_user_id (user_id),
    INDEX idx_audit_logs_action (action),
    INDEX idx_audit_logs_module (module),
    INDEX idx_audit_logs_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert Default Administrator User
-- Password: 'password' (hashed with bcrypt)
INSERT INTO users (name, email, password, role, is_active, email_verified_at, created_at, updated_at) VALUES
('Administrator', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'administrator', 1, NOW(), NOW(), NOW());

COMMIT;
