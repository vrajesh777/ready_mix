<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaveRestrictionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_restrictions', function (Blueprint $table) {
            $table->id();
            $table->integer('leave_type_id');
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
        Schema::dropIfExists('leave_restrictions');
    }
}
