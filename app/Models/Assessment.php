<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assessment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'patient_id',
        'created_by',
        'father_name',
        'father_occupation',
        'mother_name',
        'mother_occupation',
        'family_members',
        'siblings',
        'birth_order',
        'family_composition',
        'family_income_source',
        'monthly_income',
        'classification',
        'classification_remarks',
        'medical_history',
        'current_diagnosis',
        'hospital_name',
        'admission_date',
        'discharge_date',
        'food_expenses',
        'rent_expenses',
        'utilities_expenses',
        'transportation_expenses',
        'medical_expenses',
        'education_expenses',
        'other_expenses',
        'total_expenses',
        'presenting_problems',
        'client_concerns',
        'housing_type',
        'housing_condition',
        'water_source',
        'sanitation_type',
        'electricity',
        'education_level',
        'school_name',
        'currently_enrolled',
        'current_needs',
        'intervention_provided',
        'assessment_statement',
        'recommendations',
        'status',
        'submitted_at',
        'completed_at',
    ];

    protected $casts = [
        'admission_date' => 'date',
        'discharge_date' => 'date',
        'submitted_at' => 'datetime',
        'completed_at' => 'datetime',
        'currently_enrolled' => 'boolean',
        'monthly_income' => 'decimal:2',
        'food_expenses' => 'decimal:2',
        'rent_expenses' => 'decimal:2',
        'utilities_expenses' => 'decimal:2',
        'transportation_expenses' => 'decimal:2',
        'medical_expenses' => 'decimal:2',
        'education_expenses' => 'decimal:2',
        'other_expenses' => 'decimal:2',
        'total_expenses' => 'decimal:2',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeSubmitted($query)
    {
        return $query->where('status', 'submitted');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function calculateTotalExpenses()
    {
        $this->total_expenses = 
            ($this->food_expenses ?? 0) +
            ($this->rent_expenses ?? 0) +
            ($this->utilities_expenses ?? 0) +
            ($this->transportation_expenses ?? 0) +
            ($this->medical_expenses ?? 0) +
            ($this->education_expenses ?? 0) +
            ($this->other_expenses ?? 0);
        
        $this->save();
    }
}
