<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplyOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supply_order', function (Blueprint $table) {
            $table->id();
            $table->integer('dept_id')->nullable();
            $table->string('order_no',125)->nullable();
            $table->date('delivery_date')->nullable();
            $table->integer('vechicle_id')->nullable();
            $table->enum('status',['Pending','Delivered'])->default('Pending')->nullable();
            $table->text('note')->nullable()->collation('utf8_general_ci');
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
        Schema::dropIfExists('supply_order');
    }
}
