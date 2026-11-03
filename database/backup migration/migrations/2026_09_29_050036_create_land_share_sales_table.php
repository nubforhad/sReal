<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('land_share_sales', function (Blueprint $table) {
            $table->id();
            /*  Company / Branch / Project */
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained('branches')->cascadeOnDelete();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->foreignId('land_id')->constrained('lands')->restrictOnDelete();
            $table->foreignId('client_id')->constrained('clients')->restrictOnDelete();
            /*  Sale Information */
            $table->string('sale_code');
            $table->date('sale_date');
            $table->decimal('share_size', 12, 4);
            $table->string('share_unit')->default('decimal');
            $table->decimal('price_per_unit', 15, 2)->default(0);
            $table->decimal('land_share_price', 15, 2)->default(0);
            $table->enum('status', [
                'draft',
                'confirmed',
                'cancelled',
                'completed',
            ])->default('draft');
            $table->text('remarks')->nullable();
            $table->timestamps();
            $table->unique([
                'branch_id',
                'sale_code',
            ]);
            $table->index([
                'branch_id',
                'project_id',
            ]);
            $table->index([
                'land_id',
                'client_id',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('land_share_sales');
    }
};