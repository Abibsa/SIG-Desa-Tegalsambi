<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Tabel untuk data pendidikan per wilayah
        Schema::create('pendidikans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wilayah_id')->constrained('wilayahs')->onDelete('cascade');
            $table->string('tingkat_pendidikan');
            $table->integer('jumlah')->default(0);
            $table->timestamps();
        });

        // Tabel untuk data pekerjaan per wilayah
        Schema::create('pekerjaans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wilayah_id')->constrained('wilayahs')->onDelete('cascade');
            $table->string('jenis_pekerjaan');
            $table->integer('jumlah')->default(0);
            $table->timestamps();
        });

        // Tabel untuk data agama per wilayah
        Schema::create('agamas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wilayah_id')->constrained('wilayahs')->onDelete('cascade');
            $table->string('agama');
            $table->integer('jumlah')->default(0);
            $table->timestamps();
        });

        // Tabel untuk data umur per wilayah
        Schema::create('umurs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wilayah_id')->constrained('wilayahs')->onDelete('cascade');
            $table->string('rentang_umur');
            $table->integer('jumlah')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('umurs');
        Schema::dropIfExists('agamas');
        Schema::dropIfExists('pekerjaans');
        Schema::dropIfExists('pendidikans');
    }
};
