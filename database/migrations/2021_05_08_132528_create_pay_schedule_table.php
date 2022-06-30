<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pay_schedule', function (Blueprint $table) {
            $table->id();
            $table->enum('salary_on',['1','0'])->comment('0-Actual days in month , 1-Org working days');
            $table->integer('days_per_month')->nullable();
            $table->enum('pay_on',['1','0'])->comment('0-last working day of every month , 1- day of every month');
            $table->integer('on_every_month')->nullable();
            $table->string('start_payroll',125)->nullable();
            $table->date('first_pay_date')->nullable();
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
        Schema::dropIfExists('pay_schedule');
    }
}
