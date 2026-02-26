<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lotteries', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->string('slug')->unique();
            $table->unsignedTinyInteger('numbers_per_draw');

            $table->unsignedTinyInteger('numbers_per_line')
                ->comment('Quantity of numbers displayed in the physical card per line');

            $table->unsignedSmallInteger('max_number');
            $table->unsignedTinyInteger('min_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lotteries');
    }
};
