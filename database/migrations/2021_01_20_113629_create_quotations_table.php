<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->integer('vendor_id');
            $table->integer('pur_req_id');
            $table->string('estimate_number',60)->nullable()->collation('utf8_general_ci');
            $table->integer('user_id');
            $table->float('sub_total',10,2);
            $table->float('discount_percentage',10,2);
            $table->float('discount_amount',10,2);
            $table->float('grand_total',10,2);
            $table->text('vendor_note')->nullable()->collation('utf8_general_ci');
            $table->text('terms_conditions')->nullable()->collation('utf8_general_ci');
            $table->date('estimate_date')->nullable();
            $table->date('expiry_Date')->nullable();
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
        Schema::dropIfExists('quotations');
    }
}
