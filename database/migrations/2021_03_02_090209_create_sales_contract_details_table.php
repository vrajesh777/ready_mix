<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesContractDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_contract_details', function (Blueprint $table) {
            $table->id();
            $table->integer('contr_id');
            $table->integer('product_id');
            $table->integer('quantity')->default(1);
            $table->float('rate',10,2);
            $table->integer('tax_id')->nullable();
            $table->float('tax_rate',10,2)->nullable();
            $table->double('opc_1_rate',10,2)->nullable();
            $table->double('src_5_rate',10,2)->nullable();
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
        Schema::dropIfExists('sales_contract_details');
    }
}
