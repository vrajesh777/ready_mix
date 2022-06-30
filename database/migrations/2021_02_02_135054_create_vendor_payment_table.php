<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_payment', function (Blueprint $table) {
            $table->id();
            $table->integer('pur_order_id');
            $table->integer('vendor_id');
            $table->double('amount',10,2);
            $table->integer('pay_method_id');
            $table->string('trans_id',255)->nullable();
            $table->date('pay_date');
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
        Schema::dropIfExists('vendor_payment');
    }
}
