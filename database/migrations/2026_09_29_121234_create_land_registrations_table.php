<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('land_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained('branches')->cascadeOnDelete();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->foreignId('land_share_sale_id')->constrained('land_share_sales')->restrictOnDelete();
            $table->foreignId('client_id')->constrained('clients')->restrictOnDelete();
            /* Registration Information */
            $table->string('registration_code');
            $table->string('deed_no')->nullable();
            $table->date('registration_date')->nullable();
            $table->string('sub_registry_office')->nullable();
            $table->string('district')->nullable();
            $table->string('upazila')->nullable();
            $table->string('mouza')->nullable();
            $table->string('khatian_no')->nullable();
            $table->string('dag_no')->nullable();
            $table->string('jl_no')->nullable();
            /* Land Information */
            $table->decimal('registered_land_size', 12, 4)->nullable();
            $table->string('land_unit')->default('decimal');
            /*  Cost Information */
            $table->decimal('registration_cost', 15, 2)->default(0);
            $table->decimal('other_cost', 15, 2)->default(0);
            $table->decimal('total_cost', 15, 2)->default(0);
            /*  Documents */
            $table->string('deed_document')->nullable();
            $table->string('registration_document')->nullable();
            $table->string('other_document')->nullable();
            /*  Status */
            $table->enum('status', [
                'pending',
                'processing',
                'completed',
                'cancelled',
            ])->default('pending');
            $table->text('remarks')->nullable();
            $table->timestamps();
            /*  Indexes */
            $table->unique([
                'branch_id',
                'registration_code',
            ]);
            $table->index([
                'branch_id',
                'project_id',
            ]);
            $table->index('registration_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('land_registrations');
    }
};