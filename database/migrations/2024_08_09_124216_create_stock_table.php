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
        Schema::create('stock', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('barcode')->unique();  // barcode column
            $table->string('item_name');  // item_name column
            $table->string('sku')->unique();  // sku column
            $table->integer('qty');  // qty column
            $table->string('storage_location');  // storage_location column
            $table->enum('status', ['inbound', 'outbound']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock');
    }
};
