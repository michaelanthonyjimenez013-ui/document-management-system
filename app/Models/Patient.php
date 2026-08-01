<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'health_record_number',
        'mswd_number',
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'birth_date',
        'age',
        'sex',
        'civil_status',
        'place_of_birth',
        'nationality',
        'religion',
        'guardian_name',
        'guardian_relationship',
        'guardian_contact',
        'phone_number',
        'mobile_number',
        'email',
        'house_number',
        'street',
        'barangay',
        'city_municipality',
        'province',
        'zip_code',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->middle_name} {$this->last_name} {$this->suffix}");
    }

    public function getFullAddressAttribute(): string
    {
        $address = [];
        if ($this->house_number) $address[] = $this->house_number;
        if ($this->street) $address[] = $this->street;
        $address[] = $this->barangay;
        $address[] = $this->city_municipality;
        $address[] = $this->province;
        if ($this->zip_code) $address[] = $this->zip_code;
        
        return implode(', ', $address);
    }

    public function assessments()
    {
        return $this->hasMany(Assessment::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeArchived($query)
    {
        return $query->where('status', 'archived');
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('first_name', 'like', "%{$search}%")
              ->orWhere('middle_name', 'like', "%{$search}%")
              ->orWhere('last_name', 'like', "%{$search}%")
              ->orWhere('health_record_number', 'like', "%{$search}%")
              ->orWhere('mswd_number', 'like', "%{$search}%");
        });
    }
}
