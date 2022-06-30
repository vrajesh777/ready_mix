<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('cust_id');
            $table->integer('estimation_id')->nullable();
            $table->integer('contract_id')->nullable();
            $table->string('order_no',30)->nullable();
            $table->date('delivery_date')->nullable();
            $table->time('delivery_time')->nullable();
            $table->integer('pump')->nullable();
            $table->integer('pump_op_id')->nullable();
            $table->integer('pump_helper_id')->nullable();
            $table->integer('sales_agent')->nullable();
            $table->longText('admin_note')->nullable();
            $table->longText('client_note')->nullable();
            $table->longText('terms_conditions')->nullable();
            $table->float('sub_total',10,2)->nullable();
            $table->float('disc_amnt',10,2)->nullable();
            $table->float('grand_tot',10,2)->nullable();
            $table->string('structure',255)->nullable()->collation('utf8_general_ci');
            $table->text('remark')->nullable()->collation('utf8_general_ci');
            $table->enum('order_status',['pending','in-progress','testing','re-build','re-testing','granted'])->default('pending');
            $table->float('advance_payment',10,2)->default(0);
            $table->float('balance',10,2)->default(0);
            $table->date('extended_date')->nullable();
            $table->float('adv_plus_bal',10,2)->default(0);
            $table->enum('is_previous_order',['1','0'])->default(0);
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
        Schema::dropIfExists('orders');
    }
}
