<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkShiftTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_shift', function (Blueprint $table) {
            $table->id();
            $table->string('name',120)->nullable();
            $table->time('from')->nullable();
            $table->time('to')->nullable();
            $table->enum('shift_margin',['0','1'])->default('0');
            $table->time('margin_before')->nullable();
            $table->time('margin_after')->nullable();
            $table->text('departments')->nullable();
            $table->text('color_code')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'));
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work_shift');
    }
}
