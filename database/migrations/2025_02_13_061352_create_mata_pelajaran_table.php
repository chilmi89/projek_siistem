<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mata_pelajaran', function (Blueprint $table) {
            $table->id('id_mapel'); // Primary key dengan nama kolom 'id_mapel'
            $table->string('nama_mapel'); // Kolom untuk nama mata pelajaran
            $table->text('deskripsi'); // Kolom untuk deskripsi mata pelajaran
            $table->float('bobot'); // Kolom untuk bobot mata pelajaran
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mata_pelajaran'); // Menghapus tabel jika migration di-rollback
    }
};
