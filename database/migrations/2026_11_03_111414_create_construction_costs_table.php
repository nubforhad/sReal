<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('construction_costs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('building_id')->constrained()->cascadeOnDelete();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->foreignId('building_client_assignment_id')->constrained('building_client_assignments')->cascadeOnDelete();
            $table->foreignId('construction_cost_category_id')->constrained('construction_cost_categories')->restrictOnDelete();
            $table->date('cost_date');
            $table->date('payment_date')->nullable();
            $table->decimal('amount', 15, 2);
            $table->text('description')->nullable();
            $table->string('document')->nullable();
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->index(['company_id', 'branch_id', 'project_id']);
            $table->index(['building_id', 'client_id']);
            $table->index('cost_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('construction_costs');
    }
};