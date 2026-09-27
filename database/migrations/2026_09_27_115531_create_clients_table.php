<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            // Company / Branch / Project
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained('branches')->cascadeOnDelete();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            // Client Basic Information
            $table->string('client_code')->unique();
            $table->string('name');
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('spouse_name')->nullable();
            // Contact
            $table->string('phone');
            $table->string('alternate_phone')->nullable();
            $table->string('email')->nullable();
            // Personal Information
            $table->string('nid')->nullable()->index();
            $table->date('date_of_birth')->nullable();
            $table->string('occupation')->nullable();
            // Address
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            // Client Documents
            $table->string('photo')->nullable();
            $table->string('nid_document')->nullable();
            $table->string('other_document')->nullable();

            // Nominee Information
            $table->string('nominee_name')->nullable();
            $table->string('nominee_relation')->nullable();
            $table->string('nominee_phone')->nullable();
            $table->string('nominee_nid')->nullable();
            $table->text('nominee_address')->nullable();

            // Nominee Documents
            $table->string('nominee_photo')->nullable();
            $table->string('nominee_nid_document')->nullable();
            $table->string('nominee_other_document')->nullable();

            // Status / Remarks
            $table->enum('status', [
                'active',
                'inactive',
            ])->default('active');
            $table->text('remarks')->nullable();
            $table->timestamps();
            $table->index([
                'branch_id',
                'project_id',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
