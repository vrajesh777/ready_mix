<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('emp_id',12)->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->integer('role_id')->nullable();
            $table->integer('department_id')->nullable();
            $table->string('mobile_no')->nullable();
            $table->integer('report_to_id')->nullable();
            $table->enum('source_of_hire',['direct','referrel','web','newspaper','advertisement'])->nullable();
            $table->integer('designation_id')->nullable();
            $table->date('join_date')->nullable();
            $table->date('confirm_date')->nullable();
            $table->enum('status',['active','terminated','deceased','resigned'])->nullable();
            $table->enum('emp_type',['permanant','on-contract','temporary','trainee'])->nullable();
            $table->string('profile_image', 60)->nullable();
            $table->text('address')->nullable();
            $table->string('city', 60)->nullable();
            $table->string('state', 60)->nullable();
            $table->integer('country_id')->default('1');
            $table->string('postal_code', 30)->nullable();
            $table->date('dob')->nullable();
            $table->enum('marital_status',['single','married','divorcee'])->nullable();
            $table->enum('gender',['male','female','other'])->nullable();
            $table->string('email_token', 60)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('is_active',['0','1']);
            $table->string('driving_licence',255)->nullable()->collation('utf8_general_ci');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
