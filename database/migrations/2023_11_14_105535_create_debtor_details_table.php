<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('debtor_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('debtor_id');
            $table->string('money')->nullable();
            $table->enum('status', [1, 0])->index()->default(1);
            $table->string('expression_history')->nullable();
            $table->enum('currency_convert', [1, 0])->default(0)->comment('1-convert, 0-sum');
            $table->string('currency_id')->default(0);
            $table->string('date')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->softDeletes();
            $table->foreign('debtor_id')->references('id')->on('debtors')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('debtor_details');
    }
};
