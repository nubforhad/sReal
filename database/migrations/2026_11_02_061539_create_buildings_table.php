<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buildings', function (Blueprint $table) {
            $table->id();

            // Company, Branch & Project
            $table->unsignedBigInteger('company_id')->index();
            $table->unsignedBigInteger('branch_id')->index();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->foreignId('rajuk_approval_id')->nullable()->constrained('rajuk_approvals')->nullOnDelete();
            // Building Information
            $table->string('building_code')->nullable();
            $table->string('building_name');
            $table->string('building_type')->nullable();

            // Building Structure
            $table->unsignedInteger('number_of_floors')->nullable();
            $table->unsignedInteger('number_of_basements')->default(0);
            $table->unsignedInteger('total_flats')->nullable();

            // Construction Dates
            $table->date('construction_start_date')->nullable();
            $table->date('expected_completion_date')->nullable();
            $table->date('actual_completion_date')->nullable();

            // Contractor & Engineer
            $table->string('contractor_name')->nullable();
            $table->string('contractor_phone', 20)->nullable();
            $table->string('architect_name')->nullable();
            $table->string('engineer_name')->nullable();

            // Construction Status
            $table->enum('status', [
                'planning',
                'preparation',
                'ongoing',
                'paused',
                'completed',
                'on_hold',
            ])->default('planning');

            // Additional Information
            $table->text('description')->nullable();
            $table->string('building_image')->nullable();
            $table->string('document')->nullable();

            $table->timestamps();

            $table->index(
                ['company_id', 'branch_id', 'project_id'],
                'buildings_scope_index'
            );

            $table->index('status');
            $table->index('construction_start_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buildings');
    }
};
