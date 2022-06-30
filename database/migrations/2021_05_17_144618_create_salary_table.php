<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('pay_run_id');
            $table->double('basic',10,2)->nullable();
            $table->double('overtime_pay',10,2)->nullable();
            $table->double('lac_pay',10,2)->nullable();
            $table->double('monthly_total',10,2)->nullable();
            $table->double('gross_total',10,2)->nullable();
            $table->enum('payment_status',['paid','unpaid'])->default('unpaid')->nullable();
            $table->date('payment_date')->nullable();
            $table->integer('paid_days')->nullable();
            $table->integer('unpaid_days')->nullable();
            $table->enum('payment_type',['cheque','cash','online'])->default('cash')->nullable();
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
        Schema::dropIfExists('salary');
    }
}
