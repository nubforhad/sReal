<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('land_share_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained('branches')->cascadeOnDelete();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->foreignId('land_share_sale_id')->constrained('land_share_sales')->restrictOnDelete();
            $table->foreignId('client_id')->constrained('clients')->restrictOnDelete();
            $table->string('receipt_no');
            $table->date('payment_date');
            $table->decimal('amount', 15, 2);
            $table->enum('payment_method', [
                'cash',
                'bank',
                'cheque',
                'mobile_banking',
                'online',
                'other',
            ])->default('cash');

            $table->string('transaction_no')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('cheque_no')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
            $table->unique([
                'branch_id',
                'receipt_no',
            ]);
            $table->index([
                'branch_id',
                'project_id',
            ]);
            $table->index([
                'land_share_sale_id',
                'client_id',
            ]);
            $table->index('payment_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('land_share_payments');
    }
};