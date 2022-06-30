<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_request', function (Blueprint $table) {
            $table->id();
            $table->string('purchase_request_code',30)->nullable()->collation('utf8_general_ci');
            $table->string('purchase_request_name',120)->nullable()->collation('utf8_general_ci');
            $table->integer('department_id');
            $table->integer('user_id');
            $table->text('description')->nullable()->collation('utf8_general_ci');
            $table->enum('status',['1','2','3'])->default('2')->comment('1-Not yet approve , 2-Approved , 3-Reject');
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
        Schema::dropIfExists('purchase_request');
    }
}
