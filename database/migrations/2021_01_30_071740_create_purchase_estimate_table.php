<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseEstimateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_estimate', function (Blueprint $table) {
            $table->id();
            $table->string('estimate_no')->nullable();
            $table->integer('vendor_id');
            $table->integer('pur_req_id');
            $table->integer('user_id');
            $table->date('estimate_date');
            $table->date('expiry_date');
            $table->enum('status',['1','2','3'])->default('2')->comment('1-Not yet approve , 2-Approved , 3-Reject');
            $table->double('sub_total',10,2)->nullable();
            $table->double('dc_percent',10,2)->nullable();
            $table->double('dc_total',10,2)->nullable();
            $table->double('after_discount',10,2)->nullable();
            $table->double('total',10,2)->nullable();
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
        Schema::dropIfExists('purchase_estimate');
    }
}
