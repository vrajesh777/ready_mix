<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('dept_id')->nullable();
            $table->integer('invoice_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('contract_id')->nullable();
            $table->integer('order_id')->nullable();
            $table->double('amount',10,2);
            $table->enum('type',['credit','debit'])->default('credit');
            $table->integer('pay_method_id')->nullable();
            $table->date('pay_date');
            $table->string('trans_no')->nullable();
            $table->text('note')->nullable();
            $table->enum('is_show',['0','1'])->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'));
            $table->timestamp('deleted_at')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
