<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pois', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kategori'); // Pendidikan, Agama, Kesehatan, Pemerintahan, Lainnya
            $table->string('jenis')->nullable(); // SD, MI, Masjid, dll
            $table->text('alamat')->nullable();
            $table->string('kontak')->nullable();
            $table->text('fasilitas')->nullable();
            $table->string('pengelola')->nullable();
            $table->string('web')->nullable();
            $table->text('deskripsi')->nullable();
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pois');
    }
};
