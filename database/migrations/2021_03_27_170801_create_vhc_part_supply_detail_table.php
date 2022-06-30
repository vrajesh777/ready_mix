<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVhcPartSupplyDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vhc_part_supply_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('supply_order_id');
            $table->integer('make_id');
            $table->integer('model_id');
            $table->integer('year_id');
            $table->integer('part_id');
            $table->integer('quantity');
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
        Schema::dropIfExists('vhc_part_supply_detail');
    }
}
