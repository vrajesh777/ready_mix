<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResetPassTokenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reset_pass_token', function (Blueprint $table) {
            $table->id();
            $table->integer('cust_id')->nullable();
            $table->string('token',30)->nullable();
            $table->timestamp('expire_at');
            $table->enum('is_used',['1','0'])->default('0');
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
        Schema::dropIfExists('reset_pass_token');
    }
}
