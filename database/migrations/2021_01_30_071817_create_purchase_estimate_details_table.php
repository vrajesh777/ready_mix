<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseEstimateDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_estimate_details', function (Blueprint $table) {
            $table->id();
            $table->integer('pur_estimate_id');
            $table->integer('item_id');
            $table->integer('unit_id');
            $table->double('unit_price',10,2);
            $table->integer('quantity');
            $table->double('net_total',10,2)->nullable();
            $table->integer('tax_id')->nullable();
            $table->double('tax_rate',10,2)->nullable();
            $table->double('net_total_after_tax',10,2)->nullable();
            $table->double('discount_per',10,2)->nullable();
            $table->double('discount_money',10,2)->nullable();
            $table->double('total',10,2);
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
        Schema::dropIfExists('purchase_estimate_details');
    }
}
