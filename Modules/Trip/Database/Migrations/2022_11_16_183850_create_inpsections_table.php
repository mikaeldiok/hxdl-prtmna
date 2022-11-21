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
            $table->bigInteger('tanker_id')->nullable();
            $table->bigInteger('day_id')->nullable();
            $table->string('amt1')->nullable();
            $table->string('amt2')->nullable();
            $table->longText('inspection_array')->nullable();
            $table->string('odometer')->nullable();
            $table->string('photo_odometer')->nullable();
            $table->string('tambahan')->nullable();
            $table->double('pretrip_percentage')->nullable();
            $table->string('status')->nullable()->default('OFF');
            $table->string('jenis_pekerjaan_penyelesaian')->nullable();
            $table->string('keterangan_penyelesaian')->nullable();
            $table->date('estimasi_penyelesaian')->nullable();
            $table->boolean('verify_mandatory_check')->nullable();
            $table->boolean('verify_by_pengawas')->nullable();
            $table->boolean('verify_by_hsse')->nullable();
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
