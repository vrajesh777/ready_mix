<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_units', function (Blueprint $table) {
            $table->id();
            $table->string('unit_code',30)->nullable()->collation('utf8_general_ci');
            $table->string('unit_name',30)->nullable()->collation('utf8_general_ci');
            $table->text('unit_symbol')->nullable()->collation('utf8_general_ci');
            $table->text('note')->nullable()->collation('utf8_general_ci');
            $table->enum('is_active',['1','0'])->default('1');
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
        Schema::dropIfExists('purchase_units');
    }
}
