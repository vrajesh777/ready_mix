<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryDeliveryVoucherDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_delivery_voucher_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('deliv_voucher_id');
            $table->string('comm_code',60);
            $table->integer('warehouse_id');
            $table->integer('unit_id');
            $table->integer('quantity');
            $table->float('unit_price',10,2)->nullable();
            $table->integer('tax_id');
            $table->float('sub_total',10,2)->nullable();
            $table->float('discount_percentage',10,2)->nullable();
            $table->float('discount_amount',10,2)->nullable();
            $table->float('total_payment',10,2)->nullable();
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
        Schema::dropIfExists('inventory_delivery_voucher_detail');
    }
}
