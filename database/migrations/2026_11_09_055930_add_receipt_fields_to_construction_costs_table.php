
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('construction_costs', function (Blueprint $table) {

            $table->string('receipt_no')->unique();
            $table->string('purpose')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('cheque_no')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_branch')->nullable();
            $table->string('amount_words')->nullable();

        });
    }

    public function down(): void
    {
        Schema::table('construction_costs', function (Blueprint $table) {

            $table->dropColumn([
                'purpose',
                'payment_method',
                'cheque_no',
                'bank_name',
                'bank_branch',
                'amount_words',
            ]);

        });
    }
};
