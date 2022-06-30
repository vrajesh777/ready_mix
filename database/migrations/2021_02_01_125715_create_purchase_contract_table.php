<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseContractTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_contract', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('contract_no')->nullable();
            $table->string('contract_id','125')->nullable();
            $table->integer('pur_order_id')->nullable();
            $table->integer('vendor_id')->nullable();
            $table->double('contract_value',10,2)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('pay_days')->nullable();
            $table->enum('sign_status',['1','0'])->default('0')->comment('1-Signed , 0-Not Signed');
            $table->date('signed_date')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('purchase_contract');
    }
}
