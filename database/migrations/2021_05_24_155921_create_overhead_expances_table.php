<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOverheadExpancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('overhead_expances', function (Blueprint $table) {
            $table->id();
            $table->string('name','125')->collation('utf8_general_ci');
            $table->enum('type',['percentage','flat'])->default('flat');
            $table->double('value',10,2)->nullable();
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
        Schema::dropIfExists('overhead_expances');
    }
}
