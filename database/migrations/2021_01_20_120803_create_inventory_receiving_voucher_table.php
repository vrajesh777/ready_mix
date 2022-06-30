<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryReceivingVoucherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_receiving_voucher', function (Blueprint $table) {
            $table->id();
            $table->string('docket_number',30);
            $table->date('accounting_date');
            $table->date('day_vouchers');
            $table->string('supplier_name',30)->nullable()->collation('utf8_general_ci');
            $table->string('deliver_name',30)->nullable()->collation('utf8_general_ci');
            $table->integer('buyer_id');
            $table->text('note')->nullable()->collation('utf8_general_ci');
            $table->float('total_tax_amount',10,2);
            $table->float('total_goods_amount',10,2);
            $table->float('value_of_inventory',10,2);
            $table->float('total_payment',10,2);
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
        Schema::dropIfExists('inventory_receiving_voucher');
    }
}
