<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('building_client_assignments', function (Blueprint $table) {
            $table->id();

            // Company / Branch / Project
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained('branches')->cascadeOnDelete();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            // Building & Client
            $table->foreignId('building_id')->constrained('buildings')->cascadeOnDelete();
            $table->foreignId('client_id')->constrained('clients')->cascadeOnDelete();

            // Assignment Information
            $table->date('assigned_at')->nullable();

            $table->enum('status', [
                'active',
                'inactive',
            ])->default('active');

            $table->text('remarks')->nullable();

            $table->timestamps();

            // Prevent duplicate assignment
            $table->unique(
                ['building_id', 'client_id'],
                'building_client_unique'
            );

            $table->index([
                'company_id',
                'branch_id',
                'project_id',
            ]);

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('building_client_assignments');
    }
};