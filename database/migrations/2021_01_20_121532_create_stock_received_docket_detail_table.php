<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockReceivedDocketDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_received_docket_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('voucher_id');
            $table->string('comm_code',60);
            $table->integer('warehouse_id');
            $table->integer('unit_id');
            $table->integer('quantity');
            $table->float('unit_price',10,2);
            $table->integer('tax_id');
            $table->float('goods_amount',10,2);
            $table->float('tax_amount',10,2);
            $table->string('lot_number',20);
            $table->date('manufacture_date');
            $table->date('expiry_date');
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
        Schema::dropIfExists('stock_received_docket_detail');
    }
}
