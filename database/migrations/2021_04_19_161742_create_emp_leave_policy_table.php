<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpLeavePolicyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emp_leave_policy', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('leave_types_id')->nullable();
            $table->enum('type',['paid','unpaid','on_duty','restricted_holidays'])->default('paid');
            $table->enum('unit',['days','hours'])->default('days');
            $table->text('description',['days','hours'])->nullable();
            $table->date('start')->nullable();
            $table->date('end')->nullable();
            $table->integer('paid_days')->nullable();
            $table->integer('unpaid_days')->nullable();
            $table->text('genders')->nullable();
            $table->text('marital_status')->nullable();
            $table->text('departments')->nullable();
            $table->text('designations')->nullable();
            $table->text('employee_types')->nullable();
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
            $table->integer('carry_forword_overall_limit')->nullable();
            $table->integer('take_overall_limit')->nullable();
            $table->integer('reset_encash_num')->nullable();
            $table->string('encash_type',30)->nullable();
            $table->integer('reset_encash_limit')->nullable();
            $table->integer('include_weekends')->nullable();
            $table->integer('inc_weekends_after')->nullable();
            $table->integer('inc_holidays')->nullable();
            $table->integer('incholidays_after')->nullable();
            $table->integer('exceed_maxcount')->nullable();
            $table->integer('exceed_allow_opt')->nullable();
            $table->text('duration_allowed')->nullable();
            $table->string('report_display',60)->nullable();
            $table->string('balance_display',60)->nullable();
            $table->integer('pastbooking_enable')->nullable();
            $table->integer('pastbooking_limit_enable')->nullable();
            $table->integer('pastbooking_limit')->nullable();
            $table->integer('futurebooking_enable')->nullable();
            $table->integer('futurebooking_limit_enable')->nullable();
            $table->integer('futurebooking_limit')->nullable();
            $table->integer('futurebooking_notice_enable')->nullable();
            $table->integer('futurebooking_notice')->nullable();
            $table->integer('min_leave_enable')->nullable();
            $table->integer('min_leave')->nullable();
            $table->integer('max_leave_enable')->nullable();
            $table->integer('max_leave')->nullable();
            $table->integer('max_consecutive_enable')->nullable();
            $table->integer('max_consecutive')->nullable();
            $table->integer('min_gap_enable')->nullable();
            $table->integer('min_gap')->nullable();
            $table->integer('show_fileupload_after_enable')->nullable();
            $table->integer('show_fileupload_after')->nullable();
            $table->integer('frequency_count')->nullable();
            $table->string('frequency_period',60)->nullable();
            $table->text('applydates')->nullable();
            $table->text('blocked_clubs')->nullable();
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
        Schema::dropIfExists('emp_leave_policy');
    }
}
