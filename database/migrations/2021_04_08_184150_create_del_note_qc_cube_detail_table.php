<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDelNoteQcCubeDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('del_note_qc_cube_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('delivery_note_id');
            $table->date('date_tested')->nullable();
            $table->integer('age_days')->nullable();
            $table->double('weight',10,2)->nullable();
            $table->double('s_area',10,2)->nullable();
            $table->double('height',10,2)->nullable();
            $table->string('density',125)->nullable()->collation('utf8_general_ci');
            $table->double('m_load',10,2)->nullable();
            $table->double('c_strength',10,2)->nullable();
            $table->string('type_of_fraction',25)->collation('utf8_general_ci')->nullable();
            $table->float('c_strength_kg',10,2)->nullable();
            $table->enum('type',['cube','cylinder'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('del_note_qc_cube_detail');
    }
}
