<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            
            // Demographic Information
            $table->string('father_name')->nullable();
            $table->string('father_occupation')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('mother_occupation')->nullable();
            $table->integer('family_members')->nullable();
            $table->integer('siblings')->nullable();
            $table->integer('birth_order')->nullable();
            
            // Family Information
            $table->text('family_composition')->nullable();
            $table->text('family_income_source')->nullable();
            $table->decimal('monthly_income', 10, 2)->nullable();
            
            // MSWD Classification
            $table->enum('classification', ['a', 'b', 'c', 'd'])->nullable();
            $table->text('classification_remarks')->nullable();
            
            // Medical History
            $table->text('medical_history')->nullable();
            $table->text('current_diagnosis')->nullable();
            $table->string('hospital_name')->nullable();
            $table->date('admission_date')->nullable();
            $table->date('discharge_date')->nullable();
            
            // Monthly Expenses
            $table->decimal('food_expenses', 10, 2)->nullable();
            $table->decimal('rent_expenses', 10, 2)->nullable();
            $table->decimal('utilities_expenses', 10, 2)->nullable();
            $table->decimal('transportation_expenses', 10, 2)->nullable();
            $table->decimal('medical_expenses', 10, 2)->nullable();
            $table->decimal('education_expenses', 10, 2)->nullable();
            $table->decimal('other_expenses', 10, 2)->nullable();
            $table->decimal('total_expenses', 10, 2)->nullable();
            
            // Presenting Problems
            $table->text('presenting_problems')->nullable();
            $table->text('client_concerns')->nullable();
            
            // Housing Information
            $table->enum('housing_type', ['owned', 'rented', 'shared', 'informal_settler'])->nullable();
            $table->text('housing_condition')->nullable();
            $table->enum('water_source', ['piped', 'well', 'spring', 'others'])->nullable();
            $table->enum('sanitation_type', ['sewered', 'septic_tank', 'open_pit', 'others'])->nullable();
            $table->enum('electricity', ['available', 'not_available'])->nullable();
            
            // Education
            $table->enum('education_level', ['none', 'elementary', 'high_school', 'college', 'vocational'])->nullable();
            $table->string('school_name')->nullable();
            $table->boolean('currently_enrolled')->default(false);
            
            // Current Needs
            $table->text('current_needs')->nullable();
            $table->text('intervention_provided')->nullable();
            
            // Assessment Statement
            $table->text('assessment_statement')->nullable();
            $table->text('recommendations')->nullable();
            
            // Status
            $table->enum('status', ['draft', 'submitted', 'completed'])->default('draft');
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assessments');
    }
};
