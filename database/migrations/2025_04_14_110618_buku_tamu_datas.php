<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buku_tamu_datas', function (Blueprint $table) {
            $table->id();
            $table->string('bkd_no', 30)->nullable(false);
            $table->date('bkd_tanggal_kunjungan')->nullable(false);
            $table->time('bkd_jam_kunjungan')->nullable(false);
            $table->string('bkd_identitas', 20)->nullable();
            $table->string('bkd_nama', 50)->nullable(false);
            $table->char('bkd_jenis_kelamin', 1)->nullable(false);
            $table->string('bkd_telepon', 20)->nullable();
            $table->string('bkd_instansi', 200)->nullable(false);
            $table->string('bkd_keperluan', 500)->nullable(false);
            $table->unsignedBigInteger('bkd_rombongan')->default(0);
            $table->string('bkd_kartu_akses_id', 50)->nullable();
            $table->string('bkd_kartu_akses_nama', 50)->nullable();
            $table->char('bkd_status', 1)->nullable(false);
            $table->string('created_by', 50)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->string('updated_by', 50)->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buku_tamu_datas');
    }
};