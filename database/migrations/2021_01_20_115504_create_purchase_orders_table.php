<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('dept_id')->nullable();
            $table->string('name',120)->nullable()->collation('utf8_general_ci');
            $table->integer('vendor_id')->nullable();
            $table->integer('estimate_id')->nullable();
            $table->date('order_date')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('order_number',60)->nullable();
            $table->string('no_of_days_owned',60)->nullable();
            $table->date('delivery_Date')->nullable();
            $table->text('vendor_note')->nullable()->collation('utf8_general_ci');
            $table->text('terms_conditions')->nullable()->collation('utf8_general_ci');
            $table->enum('status',['1','2','3','4'])->default('2')->comment('1-Not yet approve , 2-Approved , 3-Reject , 4-Cancel');
            $table->double('sub_total',10,2)->nullable();
            $table->double('dc_percent',10,2)->nullable();
            $table->double('dc_total',10,2)->nullable();
            $table->double('after_discount',10,2)->nullable();
            $table->double('total',10,2)->nullable();
            $table->integer('part_id')->nullable();
            $table->integer('manufact_id')->nullable();
            $table->enum('condition',['old','new'])->default('new');
            $table->double('buy_price',10,2)->nullable();
            $table->integer('quantity')->nullable();
            $table->double('sell_price',10,2)->nullable();
            $table->string('part_no',125)->nullable();
            $table->string('warrenty','25')->nullable();
            $table->double('given_amount',10,2)->nullable();
            $table->double('pending_amount',10,2)->nullable();
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
        Schema::dropIfExists('purchase_orders');
    }
}
