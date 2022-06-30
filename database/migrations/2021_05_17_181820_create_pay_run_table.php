<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayRunTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pay_run', function (Blueprint $table) {
            $table->id();
            $table->date('pay_date');
            $table->string('for_month',25)->nullable();
            $table->string('for_year',25)->nullable();
            $table->double('net_pay',10,2)->nullable();
            $table->integer('no_of_emp')->nullable();
            $table->enum('status',['1','0'])->comment('1-Done ,0-Pending')->default('0');
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
        Schema::dropIfExists('pay_run');
    }
}
