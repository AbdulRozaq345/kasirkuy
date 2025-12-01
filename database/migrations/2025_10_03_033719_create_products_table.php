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
Schema::create('products', function (Blueprint $table) {
    $table->id();
    $table->foreignId('id_kategori')->nullable();
    $table->string('nama');
    $table->string('barcode')->unique()->nullable();
    $table->integer('stok')->default(0);
    $table->decimal('harga_beli', 10, 2);
    $table->decimal('harga_jual', 10, 2);
    $table->string('foto')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
