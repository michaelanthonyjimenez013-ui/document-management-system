<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('assessment_id')->nullable()->constrained('assessments')->onDelete('set null');
            $table->foreignId('uploaded_by')->constrained('users')->onDelete('cascade');
            
            $table->string('file_name');
            $table->string('file_path');
            $table->string('file_type');
            $table->string('file_size');
            $table->string('mime_type');
            
            $table->enum('category', [
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
            ])->default('other');
            
            $table->text('description')->nullable();
            $table->boolean('is_archived')->default(false);
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
