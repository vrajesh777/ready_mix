<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBreakTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('break', function (Blueprint $table) {
            $table->id();
            $table->string('title',255)->nullable()->collation('utf8_general_ci');
            $table->enum('pay_type',['paid','unpaid'])->default('paid');
            $table->enum('mode',['automatic','manual'])->default('automatic');
            $table->time('start')->nullable();
            $table->time('end')->nullable();
            $table->string('allowed_duration', 60)->nullable();
            $table->text('applicable_shifts')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'));
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('break');
    }
}
