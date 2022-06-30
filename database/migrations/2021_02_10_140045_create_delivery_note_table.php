<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryNoteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_note', function (Blueprint $table) {
            $table->id();
            $table->string('delivery_no',30)->nullable();
            $table->integer('order_detail_id');
            $table->integer('vehicle_id');
            $table->integer('driver_id');
            $table->integer('quantity');
            $table->integer('pump')->nullable();
            $table->integer('load_no');
            $table->integer('reject_by')->nullable()->comment('1.Internal Reason , 2.Customer , 3.Excess Qty');
            $table->integer('reject_qty')->nullable();
            $table->integer('excess_qty')->nullable();
            $table->integer('is_transfer')->nullable()->comment('1.Transfer , 2.Lost/Wastage');
            $table->integer('transfer_to')->nullable()->comment('1.New Customer , 2.Same Customer');
            $table->integer('to_customer_id')->nullable();
            $table->text('remark')->nullable()->collation('utf8_general_ci');
            $table->date('delivery_date');
            $table->enum('status',['pending','loaded','dispatched','delivered','cancelled'])->default('pending');
            $table->integer('from_customer_id')->nullable();
            $table->integer('to_delivery_id')->nullable();
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
        Schema::dropIfExists('delivery_note');
    }
}
