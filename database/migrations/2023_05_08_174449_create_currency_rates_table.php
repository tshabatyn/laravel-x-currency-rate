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
        Schema::create('currency_rates', function (Blueprint $table) {
            $table->id();
            $table->string('from', 3);
            $table->string('to', 3);
            $table->decimal('rate', 8, 6, true);
            $table->date('date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currency_rates');
    }
};
