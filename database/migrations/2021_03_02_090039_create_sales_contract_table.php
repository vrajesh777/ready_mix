<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesContractTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_contract', function (Blueprint $table) {
            $table->id();
            $table->string('contract_no',30)->nullable();
            $table->integer('cust_id');
            $table->string('title',30)->collation('utf8_general_ci')->nullable();
            $table->integer('sales_agent')->nullable();
            $table->longText('admin_note')->nullable()->collation('utf8_general_ci');
            $table->longText('client_note')->nullable()->collation('utf8_general_ci');
            $table->text('site_location')->nullable()->collation('utf8_general_ci');
            $table->float('excepted_m3',10,2)->nullable();
            $table->longText('terms_conditions')->nullable()->collation('utf8_general_ci');
            $table->enum('status',['unsigned','signed'])->default('unsigned');
            $table->string('compressive_strength',25)->collation('utf8_general_ci')->nullable();
            $table->string('structure_element',25)->collation('utf8_general_ci')->nullable();
            $table->string('slump',25)->collation('utf8_general_ci')->nullable();
            $table->string('concrete_temp',25)->collation('utf8_general_ci')->nullable();
            $table->string('quantity',25)->collation('utf8_general_ci')->nullable();
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
        Schema::dropIfExists('sales_contract');
    }
}
