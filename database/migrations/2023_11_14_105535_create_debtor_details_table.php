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
            $table->timestamps();
            $table->foreign('debtor_id')->references('id')->on('debtors')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('money_differences');
        Schema::dropIfExists('debtor_details');
    }
};
