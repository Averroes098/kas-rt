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
        Schema::create('inventaris', function (Blueprint $table) {

            $table->id();

            $table->foreignId('rt_id')
                ->constrained('rts')
                ->onDelete('cascade');

            $table->string('nama_barang');

            $table->integer('jumlah');

            $table->string('kondisi');

            $table->string('lokasi');

            $table->year('tahun_perolehan');

            $table->text('keterangan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventaris');
    }
};
