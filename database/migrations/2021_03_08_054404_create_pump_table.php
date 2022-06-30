<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePumpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pump', function (Blueprint $table) {
            $table->id();
            $table->string('name',255)->nullable()->collation('utf8_general_ci');
            $table->text('location',)->nullable()->collation('utf8_general_ci');
            $table->string('lat',255)->nullable();
            $table->string('lng',255)->nullable();
            $table->integer('operator_id')->nullable();
            $table->integer('helper_id')->nullable();
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
        Schema::dropIfExists('pump');
    }
}
