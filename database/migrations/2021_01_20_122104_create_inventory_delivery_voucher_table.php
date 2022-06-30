<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryDeliveryVoucherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_delivery_voucher', function (Blueprint $table) {
            $table->id();
            $table->string('document_number',30)->nullable()->collation('utf8_general_ci');
            $table->date('accounting_date');
            $table->date('day_vouchers');
            $table->string('customer_name',120)->nullable()->collation('utf8_general_ci');
            $table->string('order_no',120)->nullable()->collation('utf8_general_ci');
            $table->integer('receiver_id');
            $table->text('address')->nullable()->collation('utf8_general_ci');
            $table->integer('sales_user_id');
            $table->text('note')->nullable()->collation('utf8_general_ci');
            $table->float('subtotal',10,2);
            $table->float('total_dicount',10,2);
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
        Schema::dropIfExists('inventory_delivery_voucher');
    }
}
