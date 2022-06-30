<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVhcPurPartsDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vhc_pur_parts_details', function (Blueprint $table) {
            $table->id();
            $table->integer('part_id')->nullable();
            $table->integer('pur_order_id')->nullable();
            $table->integer('make_id');
            $table->integer('model_id');
            $table->integer('year_id');
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
        Schema::dropIfExists('vhc_pur_parts_details');
    }
}
