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
        Schema::create('menu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_kategori')->constrained(
            table: 'kategori', 
            indexName: 'posts_user_id');
            $table->string('nama_menu');
            $table->string('gambar')->nullable();
            $table->decimal('harga');
            $table->enum('status',['Ready', 'Kosong'])->default('Kosong');
            $table->enum('jenis',['Minuman','Makanan'])->default('Minuman');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu');
    }
};
