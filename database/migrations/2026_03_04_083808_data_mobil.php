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
        Schema::create('mobil_datas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string( 'nama_mobil');
            $table->string('no_polisi');
            $table->string('km')->nullable();
            $table->string('bbm')->nullable();
            $table->string('peminjam_terakhir')->nullable();
            $table->string('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_mobil');
    }
};
