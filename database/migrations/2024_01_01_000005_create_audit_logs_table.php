<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            
            $table->string('action');
            $table->string('module');
            $table->text('description')->nullable();
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            
            $table->foreignId('patient_id')->nullable()->constrained('patients')->onDelete('set null');
            $table->foreignId('assessment_id')->nullable()->constrained('assessments')->onDelete('set null');
            $table->foreignId('document_id')->nullable()->constrained('documents')->onDelete('set null');
            
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
