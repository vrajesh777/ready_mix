<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('ord_id');
            $table->string('req_title',120)->nullable()->collation('utf8_general_ci');
            $table->date('reuirement_date');
            $table->date('production');
            $table->integer('requester_id');
            $table->enum('status',['requested','accepted','rejected']);
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
        Schema::dropIfExists('inventory_requests');
    }
}
