<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVechicleRepairTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vechicle_repair', function (Blueprint $table) {
            $table->id();
            $table->integer('repair_id');
            $table->integer('vechicle_id');
            $table->integer('make_id');
            $table->integer('model_id');
            $table->integer('year_id');
            $table->string('chasis_no',125);
            $table->string('regs_no',125);
            $table->string('vin',125);
            $table->text('note')->collation('utf8_general_ci')->nullable();
            $table->date('date')->nullable();
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
        Schema::dropIfExists('vechicle_repair');
    }
}
