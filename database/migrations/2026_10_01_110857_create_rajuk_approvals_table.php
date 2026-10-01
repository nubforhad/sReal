<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rajuk_approvals', function (Blueprint $table) {
            $table->id();

            // Company, Branch & Project
            $table->unsignedBigInteger('company_id')->index();
            $table->unsignedBigInteger('branch_id')->index();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            // Application Information
            $table->string('application_no')->nullable();
            $table->string('applicant_name');
            $table->string('applicant_phone', 20)->nullable();
            // Land Information
            $table->string('plot_number')->nullable();
            $table->string('road_number')->nullable();
            $table->string('block')->nullable();
            $table->string('mouza')->nullable();
            $table->string('land_area')->nullable();
            // Building Information
            $table->string('plan_type')->nullable();
            $table->unsignedInteger('number_of_floors')->nullable();
            $table->unsignedInteger('number_of_flats')->nullable();
            $table->string('architect_name')->nullable();
            $table->string('consultant_name')->nullable();
            // Application Dates
            $table->date('application_date')->nullable();
            $table->date('submission_date')->nullable();
            $table->date('approval_date')->nullable();
            // Approval Details
            $table->string('approval_number')->nullable();
            $table->enum('status', [
                'draft',
                'submitted',
                'under_review',
                'approved',
                'rejected',
                'on_hold'
            ])->default('draft');
            $table->text('remarks')->nullable();
            // Documents
            $table->string('plan_document')->nullable();
            $table->string('approval_document')->nullable();
            $table->timestamps();
            $table->index([
                'company_id',
                'branch_id',
                'project_id'
            ], 'rajuk_scope_index');
            $table->index('status');
            $table->index('application_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rajuk_approvals');
    }
};