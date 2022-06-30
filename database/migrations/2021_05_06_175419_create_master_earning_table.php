<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterEarningTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_earning', function (Blueprint $table) {
            $table->id();
            $table->string('name','255')->collation('utf8_general_ci')->nullable();
            $table->string('name_payslip','255')->collation('utf8_general_ci')->nullable();
            $table->enum('cal_type',['percentage','flat'])->nullable();
            $table->enum('is_active',['0','1'])->default('1');
            $table->integer('earning_type_id')->nullable();
            $table->double('cal_value',10,2)->nullable();
            $table->string('pay_type',25)->collation('utf8_general_ci')->nullable();
            $table->enum('pay_on',['CTC','Basic'])->default('Basic')->nullable();
            $table->integer('is_extra')->default('0');
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
        Schema::dropIfExists('master_earning');
    }
}
