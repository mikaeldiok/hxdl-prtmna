<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEvideceToInspections extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inspections', function (Blueprint $table) {
            $table->boolean('verify_evidence')->nullable();
            $table->string('evidence')->nullable();
            $table->datetime('evidence_upload_at')->nullable();;
            $table->datetime('verify_evidence_at')->nullable();
            $table->datetime('verify_by_pengawas_at')->nullable();
            $table->datetime('verify_by_hsse_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inspections', function (Blueprint $table) {

            $table->dropColumn('verify_evidence');
            $table->dropColumn('evidence');
            $table->dropColumn('evidence_upload_at');
            $table->dropColumn('verify_evidence_at');
            $table->dropColumn('verify_by_pengawas_at');
            $table->dropColumn('verify_by_hsse_at');
        });
    }
}
