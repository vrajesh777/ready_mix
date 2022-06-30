<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEarningTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('earning_type', function (Blueprint $table) {
            $table->id();
            $table->string('name','255')->collation('utf8_general_ci')->nullable();
            $table->enum('is_cal_type',['0','1'])->default('1');
            $table->enum('is_cal_val',['0','1'])->default('1');
            $table->enum('is_pay_type',['0','1'])->default('1');
            $table->enum('is_active',['0','1'])->default('1');
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
        Schema::dropIfExists('earning_type');
    }
}
