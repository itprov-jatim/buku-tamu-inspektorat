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
        Schema::create('peminjaman_datas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('token')->nullable();   
            $table->string('nama_peminjam');
            $table->foreignId('mobil_id')
                  ->references('id')
                  ->on('mobil_datas')
                  ->onDelete('restrict');
            $table->date('tanggal_berangkat');
            $table->date('tanggal_kembali');
            $table->string('km_awal')->nullable();   
            $table->string('km_akhir')->nullable();  
            $table->string('bbm')->nullable();       
            $table->string('tujuan');
            $table->string('keterangan')->nullable();
            $table->boolean('driver')->default(false);
            $table->char('status', 1)->default('P');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman_datas');
    }
};
