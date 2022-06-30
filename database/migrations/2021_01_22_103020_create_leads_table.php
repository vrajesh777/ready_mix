<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['warm','hot','junks'] );
            $table->enum('source', ['google','facebook','email','physical'] );
            $table->integer('assigned')->nullable();
            $table->text('tags')->nullable();
            $table->string('name', 260)->nullable()->collation('utf8_general_ci');
            $table->text('address')->nullable()->collation('utf8_general_ci');
            $table->string('position',120)->nullable()->collation('utf8_general_ci');
            $table->string('city',120)->nullable()->collation('utf8_general_ci');
            $table->string('email',120)->nullable();
            $table->string('state',120)->nullable()->collation('utf8_general_ci');
            $table->string('website',120)->nullable()->collation('utf8_general_ci');
            $table->integer('country')->nullable();
            $table->string('phone',20)->nullable();
            $table->string('zip_code',10)->nullable();
            $table->float('lead_value',10,2)->nullable();
            $table->integer('default_language')->nullable();
            $table->string('company',120)->nullable()->collation('utf8_general_ci');
            $table->text('description')->nullable()->collation('utf8_general_ci');
            $table->date('contacted_date');
            $table->integer('user_id')->nullable();
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
        Schema::dropIfExists('leads');
    }
}
