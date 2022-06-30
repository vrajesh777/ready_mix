<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->string('name',255)->collation('utf8_general_ci');
            $table->string('mix_code',255)->nullable()->collation('utf8_general_ci');
            $table->longText('description')->nullable()->collation('utf8_general_ci');
            $table->float('rate',10,2)->nullable();
            $table->integer('tax_id')->nullable();
            $table->integer('min_quant');
            $table->enum('is_active',['1','0'])->default('1');
            $table->float('opc_1_rate',10,2)->nullable();
            $table->float('src_5_rate',10,2)->nullable();
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
        Schema::dropIfExists('product');
    }
}
