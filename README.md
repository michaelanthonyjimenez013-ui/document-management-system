# Malasakit Program Document Management System

A working prototype of a web-based Document Management System (DMS) for the Malasakit Program that digitizes the Medical Social Work Department (MSWD) Assessment Tool for Children and Adolescents.

## Features

### User Roles
- **Administrator**: Full system access including user management
- **Medical Social Worker**: Patient management, assessments, document handling
- **Records Officer**: Document management, reports, search functionality

### Core Functionality

1. **Authentication System**
   - Secure login/logout
   - User registration (Admin only)
   - Password reset functionality
   - Role-based access control

2. **Dashboard**
   - Total patients count
   - Active cases tracking
   - Pending/completed assessments
   - Document statistics
   - Recent activity overview

3. **Patient Management**
   - Register new patients
   - Edit patient information
   - View patient profiles
   - Delete patient records (Admin only)
   - Search patients
   - Archive/restore functionality

4. **Digital MSWD Assessment Form**
   - Demographic Information
   - Family Information
   - MSWD Classification
   - Medical History
   - Monthly Expenses
   - Presenting Problems
   - Housing Information
   - Education
   - Current Needs
   - Assessment Statement
   - Draft, submit, and complete workflows

5. **Document Management**
   - Upload documents (PDF, DOC/DOCX, JPG, PNG)
   - View uploaded files
   - Download documents
   - Delete documents
   - Categorize documents
   - Preview PDF and images

6. **Document Categories**
   - MSWD Assessment Form
   - Medical Certificate
   - Birth Certificate
   - Valid ID
   - Barangay Certificate
   - Hospital Bill
   - Laboratory Result
   - Prescription
   - Referral Letter
   - Other Supporting Documents

7. **Search Module**
   - Search by patient name
   - Search by Health Record Number
   - Search by MSWD Number
   - Search by assessment date
   - Search by document category

8. **Reports**
   - Total patients report
   - Total assessments report
   - Uploaded documents report
   - Export to PDF and Excel

9. **Document Import**
   - Import PDF documents
   - Import Word documents
   - Import Excel/CSV patient lists
   - Bulk document upload
   - Duplicate file detection

10. **Document Export**
    - Export assessment to PDF
    - Export patient information to Excel
    - Export selected documents
    - Print assessment form

11. **Audit Log**
    - User login/logout tracking
    - Patient registration logs
    - Assessment creation/updates
    - Document upload/download/deletion
    - Complete activity history

12. **Archive System**
    - Archive completed cases
    - Restore archived records

## Technology Stack

### Frontend
- HTML5
- CSS3
- Bootstrap 5
- JavaScript
- Chart.js

### Backend
- PHP (Laravel 11)
- MySQL

### Libraries
- DomPDF (PDF generation)
- Laravel Excel (Excel import/export)
- Intervention Image (Image processing)

## Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- MySQL 5.7 or higher
- Node.js (optional, for asset compilation)

### Setup Instructions

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd document-management-system
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure database**
   Edit `.env` file:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=malasakit_dms
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

5. **Run migrations**
   ```bash
   php artisan migrate
   ```

6. **Create storage link**
   ```bash
   php artisan storage:link
   ```

7. **Create default administrator**
   ```bash
   php artisan db:seed --class=AdminUserSeeder
   ```

8. **Run development server**
   ```bash
   php artisan serve
   ```

9. **Access the application**
   Open your browser and navigate to: `http://localhost:8000`

## Default Credentials

After installation, log in with:
- Email: `admin@example.com`
- Password: `password`

**Important**: Change the default password after first login.

## Usage

### Adding a Patient
1. Navigate to Patients → Add Patient
2. Fill in personal information, guardian details, contact information, and address
3. Click "Save Patient"

### Creating an Assessment
1. Navigate to Patients → Select a patient
2. Click "Create Assessment"
3. Fill in all required sections of the MSWD Assessment Tool
4. Save as draft or submit for review

### Uploading Documents
1. Navigate to Documents → Upload Document
2. Select the patient and document category
3. Choose the file (PDF, DOC, DOCX, JPG, PNG)
4. Add description (optional)
5. Click "Upload"

### Searching
1. Use the search bar in the navigation
2. Enter patient name, HRN, or MSWD number
3. Filter by type (patients, assessments, documents)

### Generating Reports
1. Navigate to Reports
2. Select the type of report
3. Choose export format (PDF or Excel)
4. Click "Generate Report"

## Security Features

- Role-based access control
- Password hashing (bcrypt)
- Secure authentication
- File upload validation
- Session management
- CSRF protection
- SQL injection prevention

## Project Structure

```
document-management-system/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── PatientController.php
│   │   │   ├── AssessmentController.php
│   │   │   ├── DocumentController.php
│   │   │   ├── UserController.php
│   │   │   ├── SearchController.php
│   │   │   ├── ReportController.php
│   │   │   ├── ImportController.php
│   │   │   └── ExportController.php
│   │   └── Middleware/
│   ├── Models/
│   │   ├── User.php
│   │   ├── Patient.php
│   │   ├── Assessment.php
│   │   ├── Document.php
│   │   └── AuditLog.php
├── database/
│   ├── migrations/
│   │   ├── 2024_01_01_000001_create_users_table.php
│   │   ├── 2024_01_01_000002_create_patients_table.php
│   │   ├── 2024_01_01_000003_create_assessments_table.php
│   │   ├── 2024_01_01_000004_create_documents_table.php
│   │   └── 2024_01_01_000005_create_audit_logs_table.php
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php
│       ├── auth/
│       │   └── login.blade.php
│       ├── dashboard/
│       ├── patients/
│       ├── assessments/
│       ├── documents/
│       └── reports/
├── routes/
│   └── web.php
├── public/
│   └── storage/
└── storage/
    └── app/
        └── public/
            └── documents/
```

## Development

### Running Tests
```bash
php artisan test
```

### Code Style
```bash
php artisan pint
```

## License

This project is proprietary software for the Malasakit Program.

## Support

For technical support, contact the system administrator.

## Notes

- This is a working prototype demonstrating core functionality
- Additional features can be added as needed
- The system is designed to be scalable and maintainable
- All sensitive operations are logged for audit purposes
