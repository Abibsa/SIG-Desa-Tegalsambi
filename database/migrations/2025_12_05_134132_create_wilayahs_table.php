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
        Schema::create('wilayahs', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('tingkat')->default('rw'); // desa, dusun, rw, rt
            $table->unsignedBigInteger('parent_id')->nullable(); // Untuk hierarki
            $table->integer('kk')->default(0);
            $table->integer('l')->default(0); // Laki-laki
            $table->integer('p')->default(0); // Perempuan
            // populasi_total bisa dihitung (l+p), tidak perlu simpan jika redundan, tapi boleh ada.
            // luas_ha dan kepadatan sementara dihapus atau dibuat nullable jika tidak ada datanya
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wilayahs');
    }
};
