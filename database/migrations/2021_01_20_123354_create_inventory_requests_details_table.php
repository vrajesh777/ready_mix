<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryRequestsDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_requests_details', function (Blueprint $table) {
            $table->id();
            $table->integer('req_id');
            $table->string('comm_code',60)->nullable()->collation('utf8_general_ci');
            $table->integer('warehouse_id');
            $table->integer('unit_id');
            $table->integer('quantity');
            $table->text('note')->nullable()->collation('utf8_general_ci');
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
        Schema::dropIfExists('inventory_requests_details');
    }
}
