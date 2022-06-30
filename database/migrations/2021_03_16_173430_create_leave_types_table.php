<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaveTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_types', function (Blueprint $table) {
            $table->id();
            $table->string('title',255)->nullable()->collation('utf8_general_ci');
            $table->string('code',30)->nullable()->collation('utf8_general_ci');
            $table->enum('type',['paid','unpaid','on_duty','restricted_holidays'])->default('paid');
            $table->enum('unit',['days','hours'])->default('days');
            $table->text('description',['days','hours'])->nullable();
            $table->date('start')->nullable();
            $table->date('end')->nullable();
            $table->integer('paid_days')->nullable();
            $table->integer('unpaid_days')->nullable();
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
        Schema::dropIfExists('leave_types');
    }
}
