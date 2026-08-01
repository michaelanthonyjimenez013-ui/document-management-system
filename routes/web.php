<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\ExportController;

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Patient Management
    Route::resource('patients', PatientController::class);
    Route::get('/patients/{patient}/archive', [PatientController::class, 'archive'])->name('patients.archive');
    Route::get('/patients/{patient}/restore', [PatientController::class, 'restore'])->name('patients.restore');
    
    // Assessment Management
    Route::resource('assessments', AssessmentController::class);
    Route::post('/assessments/{assessment}/submit', [AssessmentController::class, 'submit'])->name('assessments.submit');
    Route::post('/assessments/{assessment}/complete', [AssessmentController::class, 'complete'])->name('assessments.complete');
    Route::get('/patients/{patient}/assessments/create', [AssessmentController::class, 'createForPatient'])->name('patients.assessments.create');
    
    // Document Management
    Route::resource('documents', DocumentController::class);
    Route::post('/documents/upload', [DocumentController::class, 'upload'])->name('documents.upload');
    Route::get('/documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');
    Route::get('/documents/{document}/preview', [DocumentController::class, 'preview'])->name('documents.preview');
    Route::get('/patients/{patient}/documents', [DocumentController::class, 'patientDocuments'])->name('patients.documents');
    Route::post('/documents/bulk-print', [DocumentController::class, 'bulkPrint'])->name('documents.bulk-print');
    
    // User Management (Admin Only)
    Route::middleware(['can:manage_users'])->group(function () {
        Route::resource('users', UserController::class);
        Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
        Route::post('/register', [AuthController::class, 'register']);
    });
    
    // Search
    Route::get('/search', [SearchController::class, 'index'])->name('search');
    
    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/patients', [ReportController::class, 'patientsReport'])->name('reports.patients');
    Route::get('/reports/assessments', [ReportController::class, 'assessmentsReport'])->name('reports.assessments');
    Route::get('/reports/documents', [ReportController::class, 'documentsReport'])->name('reports.documents');
    
    // Import
    Route::get('/import', [ImportController::class, 'index'])->name('import.index');
    Route::post('/import/patients', [ImportController::class, 'importPatients'])->name('import.patients');
    Route::post('/import/documents', [ImportController::class, 'importDocuments'])->name('import.documents');
    
    // Export
    Route::get('/export/assessment/{assessment}', [ExportController::class, 'exportAssessment'])->name('export.assessment');
    Route::get('/export/patient/{patient}', [ExportController::class, 'exportPatient'])->name('export.patient');
    Route::get('/export/documents', [ExportController::class, 'exportDocuments'])->name('export.documents');
    
    // Audit Logs (Admin Only)
    Route::middleware(['can:manage_users'])->group(function () {
        Route::get('/audit-logs', [UserController::class, 'auditLogs'])->name('audit-logs.index');
    });
});

// Home Route
Route::get('/', function () {
    return redirect('/login');
});
