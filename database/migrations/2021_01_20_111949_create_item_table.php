<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item', function (Blueprint $table) {
            $table->id();
            $table->integer('dept_id')->nullable();
            $table->string('commodity_code',60)->nullable()->collation('utf8_general_ci');
            $table->string('commodity_name',120)->nullable()->collation('utf8_general_ci');
            $table->string('commodity_barcode',120)->nullable()->collation('utf8_general_ci');
            $table->string('sku_code',60)->nullable()->collation('utf8_general_ci');
            $table->string('sku_name',60)->nullable()->collation('utf8_general_ci');
            $table->text('description')->nullable()->collation('utf8_general_ci');
            $table->integer('units')->nullable();
            $table->integer('commodity_group')->nullable();
            $table->integer('sub_group')->nullable();
            $table->text('tags')->nullable()->collation('utf8_general_ci');
            $table->double('rate', 10, 2)->nullable();
            $table->double('purchase_price', 10, 2)->nullable();
            $table->integer('tax_id')->nullable();
            $table->enum('is_active',['1','0'])->default('0');
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
        Schema::dropIfExists('item');
    }
}
