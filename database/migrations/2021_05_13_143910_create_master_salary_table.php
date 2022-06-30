<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterSalaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_salary', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->double('basic',10,2)->nullable();
            $table->double('monthly_total',10,2)->nullable();
            $table->double('annualy_total',10,2)->nullable();
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
        Schema::dropIfExists('master_salary');
    }
}
