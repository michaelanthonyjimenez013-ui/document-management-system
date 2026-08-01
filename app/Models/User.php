<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function isAdmin(): bool
    {
        return $this->role === 'administrator';
    }

    public function isMedicalSocialWorker(): bool
    {
        return $this->role === 'medical_social_worker';
    }

    public function isRecordsOfficer(): bool
    {
        return $this->role === 'records_officer';
    }

    public function canManageUsers(): bool
    {
        return $this->isAdmin();
    }

    public function canDeletePatients(): bool
    {
        return $this->isAdmin();
    }

    public function patientsCreated()
    {
        return $this->hasMany(Patient::class, 'created_by');
    }

    public function patientsUpdated()
    {
        return $this->hasMany(Patient::class, 'updated_by');
    }

    public function assessments()
    {
        return $this->hasMany(Assessment::class, 'created_by');
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'uploaded_by');
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }
}
