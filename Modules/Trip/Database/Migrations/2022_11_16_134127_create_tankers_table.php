<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTankersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tankers', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_polisi');
            $table->string('produk')->nullable();
            $table->string('nama_perusahaan_transportir')->nullable();
            $table->string('kategori_pengelola_mt')->nullable();
            $table->date('tahun_registrasi')->nullable();
            $table->string('merk_kepala')->nullable();
            $table->string('type')->nullable();
            $table->string('nomor_mesin')->nullable();
            $table->string('nomor_chassiss')->nullable();
            $table->string('konfigurasi_sumbu_roda')->nullable();
            $table->string('kategori')->nullable();
            $table->string('status_sewa_tarif')->nullable();
            $table->string('tujuan_angkutan')->nullable();
            $table->double('kap')->nullable();
            $table->string('no_reg')->nullable();

            $table->date('exp_stnk')->nullable();
            $table->date('exp_keur')->nullable();
            $table->date('exp_tera')->nullable();
            $table->date('exp_kip')->nullable();

            $table->date('end_date_mt')->nullable();
            $table->string('keterangan_kip')->nullable();
            $table->string('keterangan_mt')->nullable();

            $table->float('data_tm_k1_t1')->nullable();
            $table->float('data_tm_k1_t2')->nullable();
            $table->float('data_tm_k1_t3')->nullable();

            $table->float('data_tm_k2_t1')->nullable();
            $table->float('data_tm_k2_t2')->nullable();
            $table->float('data_tm_k2_t3')->nullable();

            $table->float('data_tm_k3_t1')->nullable();
            $table->float('data_tm_k3_t2')->nullable();
            $table->float('data_tm_k3_t3')->nullable();

            $table->string('nomor_surat_tera')->nullable();

            $table->string('keterengan')->nullable();

            $table->boolean('available')->default('1');
            $table->timestamps();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->integer('deleted_by')->unsigned()->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tankers');
    }
}
