<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaveEntitlementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_entitlement', function (Blueprint $table) {
            $table->id();
            $table->integer('leave_type_id');
            $table->integer('effective_period')->nullable();
            $table->enum('effective_unit',['days','months','years'])->nullable();
            $table->enum('exp_field',['date_of_join','date_of_conf'])->nullable();
            $table->enum('accrual',['0','1'])->nullable();
            $table->string('accrual_period',120)->nullable();
            $table->string('accrual_time',60)->nullable();
            $table->string('accrual_month',60)->nullable();
            $table->string('accrual_no_days',60)->nullable();
            $table->enum('accrual_mode',['current_accrual','next_accrual'])->nullable();
            $table->enum('reset',['0','1'])->nullable();
            $table->string('reset_period',60)->nullable();
            $table->string('reset_time',60)->nullable();
            $table->string('reset_month',60)->nullable();
            $table->string('cf_mode',120)->nullable();
            $table->integer('reset_carry')->nullable();
            $table->string('reset_carry_type',30)->nullable();
            $table->integer('reset_carry_limit')->nullable();
            $table->integer('reset_carry_expire_in')->nullable();
            $table->string('reset_carry_expire_unit',25)->nullable();
            $table->integer('reset_encash_num')->nullable();
            $table->string('encash_type',30)->nullable();
            $table->integer('reset_encash_limit')->nullable();

            // $table->timestamps();
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
        Schema::dropIfExists('leave_entitlement');
    }
}
