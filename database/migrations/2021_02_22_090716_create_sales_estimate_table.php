<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesEstimateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_estimate', function (Blueprint $table) {
            $table->id();
            $table->string('subject',120)->collation('utf8_general_ci');
            $table->string('related',120)->collation('utf8_general_ci');
            $table->integer('assigned_to')->nullable();
            $table->integer('lead_id')->nullable();
            $table->integer('cust_id')->nullable();
            $table->date('date');
            $table->date('open_till')->nullable();
            $table->text('tags')->nullable()->collation('utf8_general_ci');
            $table->enum('allow_comments',['yes','no']);
            $table->enum('status',['draft','sent','open','revised','declined','accepted']);
            $table->string('to')->collation('utf8_general_ci');
            $table->text('address')->nullable()->collation('utf8_general_ci');
            $table->string('city',120)->nullable()->collation('utf8_general_ci');
            $table->string('state',120)->nullable()->collation('utf8_general_ci');
            $table->string('postal_code',10)->nullable();
            $table->integer('country');
            $table->string('email',120);
            $table->string('phone',16)->nullable();
            $table->float('net_total',10,2)->nullable();
            $table->float('discount',10,2)->nullable();
            $table->enum('discount_type',['fixed','percentage'])->default('percentage');
            $table->float('grand_tot',10,2)->nullable();
            $table->text('adjustment')->nullable()->collation('utf8_general_ci');
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
        Schema::dropIfExists('sales_estimate');
    }
}
