<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotationsDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotations_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('quotation_id');
            $table->integer('item_id');
            $table->float('unit_price',10,2);
            $table->integer('quantity');
            $table->float('net_total',10,2);
            $table->float('tax',10,2);
            $table->float('gross_total',10,2);
            $table->float('discount_percentage',10,2);
            $table->float('discount_amount',10,2);
            $table->float('total',10,2);
            $table->date('estimate_date');
            $table->date('expiry_Date');
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
        Schema::dropIfExists('quotations_detail');
    }
}
