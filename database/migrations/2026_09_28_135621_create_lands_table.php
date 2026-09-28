
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lands', function (Blueprint $table) {
            $table->id();

            // Company / Branch / Project
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained('branches')->cascadeOnDelete();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            // Land Identification
            $table->string('land_code');
            $table->string('land_name')->nullable();

            // Location
            $table->string('district')->nullable();
            $table->string('upazila')->nullable();
            $table->string('mouza')->nullable();

            // Land Records
            $table->string('khatian_no')->nullable();
            $table->string('dag_no')->nullable();
            $table->string('jl_no')->nullable();

            // Land Size
            $table->decimal('total_land_size', 12, 4)->nullable();
            $table->string('land_unit')->default('decimal');

            // Ownership
            $table->string('owner_name')->nullable();
            $table->string('owner_phone')->nullable();
            $table->string('owner_nid')->nullable();

            // Purchase Information
            $table->decimal('purchase_price', 15, 2)->default(0);
            $table->date('purchase_date')->nullable();

            // Status
            $table->enum('status', [
                'available',
                'partially_sold',
                'fully_sold',
                'registered',
                'closed',
            ])->default('available');

            $table->text('description')->nullable();
            $table->text('remarks')->nullable();

            $table->timestamps();

            // Same land code can exist in different branches,
            // but not twice inside the same branch.
            $table->unique([
                'branch_id',
                'land_code',
            ]);

            $table->index([
                'branch_id',
                'project_id',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lands');
    }
};