<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterReimbursementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_reimbursement', function (Blueprint $table) {
            $table->id();
            $table->integer('reimbursement_type_id');
            $table->string('name_payslip','255')->collation('utf8_general_ci')->nullable();
            $table->double('amount',10,2)->nullable();
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
        Schema::dropIfExists('master_reimbursement');
    }
}
