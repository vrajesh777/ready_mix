<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustContractAttachmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cust_contract_attachment', function (Blueprint $table) {
            $table->id();
            $table->integer('cust_cont_id');
            $table->string('contract',255)->nullable()->collation('utf8_general_ci');
            $table->string('quotation',255)->nullable()->collation('utf8_general_ci');
            $table->string('bala_per',255)->nullable()->collation('utf8_general_ci');
            $table->string('owner_id',255)->nullable()->collation('utf8_general_ci');
            $table->string('credit_form',255)->nullable()->collation('utf8_general_ci');
            $table->string('purchase_order',255)->nullable()->collation('utf8_general_ci');
            $table->string('pay_grnt',255)->nullable()->collation('utf8_general_ci');
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
        Schema::dropIfExists('cust_contract_attachment');
    }
}
