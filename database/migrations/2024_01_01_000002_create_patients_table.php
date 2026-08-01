<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('health_record_number')->unique();
            $table->string('mswd_number')->nullable()->unique();
            
            // Personal Information
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('suffix')->nullable();
            $table->date('birth_date');
            $table->string('age');
            $table->enum('sex', ['male', 'female']);
            $table->enum('civil_status', ['single', 'married', 'widowed', 'separated', 'divorced']);
            $table->string('place_of_birth');
            $table->string('nationality')->default('Filipino');
            $table->string('religion')->nullable();
            
            // Guardian Information
            $table->string('guardian_name')->nullable();
            $table->string('guardian_relationship')->nullable();
            $table->string('guardian_contact')->nullable();
            
            // Contact Details
            $table->string('phone_number')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('email')->nullable();
            
            // Address
            $table->text('house_number')->nullable();
            $table->text('street')->nullable();
            $table->text('barangay');
            $table->text('city_municipality');
            $table->text('province');
            $table->string('zip_code')->nullable();
            
            // Status
            $table->enum('status', ['active', 'archived'])->default('active');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
