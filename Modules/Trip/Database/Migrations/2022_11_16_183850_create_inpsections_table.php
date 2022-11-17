<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInpsectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspections', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tanker_id');
            $table->bigInteger('day_id');
            $table->string('amt1');
            $table->string('amt2');
            $table->longText('insepction_array');
            $table->double('odometer');
            $table->string('tambahan');
            $table->double('pretrip_percentage');
            $table->string('status');
            $table->string('jenis_pekerjaan_penyelesaian');
            $table->string('keterangan_penyelesaian');
            $table->date('estimasi_penyelesaian');
            $table->boolean('verify_mandatory_check');
            $table->boolean('verify_by_pengawas');
            $table->boolean('verify_by_hss');
            $table->date('inspection_date');
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
        Schema::dropIfExists('inspections');
    }
}
