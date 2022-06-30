<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id');
            $table->string('invoice_number',60)->nullable();
            $table->date('invoice_date')->nullable();
            $table->date('due_date')->nullable();
            $table->integer('currency')->nullable();
            $table->float('net_total',10,2)->nullable();
            $table->float('discount',10,2)->nullable();
            $table->enum('discount_type',['fixed','percentage'])->default('percentage');
            $table->float('grand_tot',10,2)->nullable();
            $table->text('adjustment')->nullable()->collation('utf8_general_ci');
            $table->string('billing_street',200)->nullable()->collation('utf8_general_ci');
            $table->string('billing_city',100)->nullable()->collation('utf8_general_ci');
            $table->string('billing_state',100)->nullable()->collation('utf8_general_ci');
            $table->string('billing_zip',100)->nullable()->collation('utf8_general_ci');
            $table->string('billing_country',100)->nullable()->collation('utf8_general_ci');
            $table->enum('include_shipping',['0','1'])->default('0');
            $table->string('shipping_street',200)->nullable()->collation('utf8_general_ci');
            $table->string('shipping_city',100)->nullable()->collation('utf8_general_ci');
            $table->string('shipping_state',100)->nullable()->collation('utf8_general_ci');
            $table->string('shipping_zip',100)->nullable()->collation('utf8_general_ci');
            $table->string('shipping_country',100)->nullable()->collation('utf8_general_ci');
            $table->enum('status',['draft','sent','open','revised','declined','accepted'])->default('draft');
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
        Schema::dropIfExists('invoice');
    }
}
