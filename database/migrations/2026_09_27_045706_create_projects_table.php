<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            /*  Company & Branch  */
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained('branches')->cascadeOnDelete();
            /*  Project Basic Information */
            $table->string('project_code');
            $table->string('project_name');
            $table->string('project_type')->nullable();
            $table->text('location')->nullable();
            $table->string('size')->nullable();
            $table->string('image')->nullable();
            /* Project Highlights */
            $table->text('key_highlights')->nullable();
            /* Project Dates */
            $table->date('start_date')->nullable();
            $table->date('expected_completion_date')->nullable();
            /*  Project Status */
            $table->enum('status', [
                'planning',
                'ongoing',
                'completed',
                'on_hold',
                'cancelled',
            ])->default('planning');
            /* Share Status */
            $table->enum('share_status', [
                'available',
                'limited',
                'sold_out',
                'closed',
            ])->default('available');
            /* Working Status */
            $table->enum('working_status', [
                'not_started',
                'ongoing',
                'completed',
                'on_hold',
            ])->default('not_started');
            /*  Description */
            $table->text('description')->nullable();
            $table->timestamps();
            /*  Unique Project Code Per Branch */
            $table->unique([
                'branch_id',
                'project_code'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};