<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaveBalanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_balance', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('leave_type_id');
            $table->date('valid_till');
            $table->date('valid_from');
            $table->integer('balance');
            $table->integer('taken_leave')->nullable();
            $table->integer('expire_count')->nullable();
            $table->integer('lop')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leave_balance');
    }
}
