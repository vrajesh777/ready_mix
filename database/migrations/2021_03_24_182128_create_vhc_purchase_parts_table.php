<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVhcPurchasePartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vhc_purchase_parts', function (Blueprint $table) {
            $table->id();
            $table->integer('part_id');
            $table->string('order_id','25')->nullable();
            $table->integer('supply_id');
            $table->integer('manufact_id');
            $table->enum('condition',['old','new'])->default('new');
            $table->float('buy_price',10,2)->nullable();
            $table->integer('quantity');
            $table->float('sell_price',10,2)->nullable();
            $table->string('part_no','255')->collation('utf8_general_ci');
            $table->date('purch_date')->nullable();
            $table->integer('warrenty_days')->nullable();
            $table->string('warrenty_in')->nullable();
            $table->string('warrenty','25')->nullable();
            $table->float('total_amount',10,2)->nullable();
            $table->float('given_amount',10,2)->nullable();
            $table->float('pending_amount',10,2)->nullable();
            $table->string('image','255')->nullable();
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
        Schema::dropIfExists('vhc_purchase_parts');
    }
}
