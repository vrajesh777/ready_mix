<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesProposalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_proposal', function (Blueprint $table) {
            $table->id();
            $table->integer('proposal_id')->nullable();
            $table->integer('cust_id')->nullable();
            $table->string('est_num')->nullable();
            $table->string('ref_num')->nullable();
            $table->enum('status',['draft','sent','open','revised','declined','accepted']);
            $table->integer('assigned_to')->nullable();
            $table->date('date');
            $table->date('expiry_date')->nullable();
            $table->text('tags')->nullable()->collation('utf8_general_ci');
            $table->text('admin_note')->nullable()->collation('utf8_general_ci');
            $table->text('client_note')->nullable()->collation('utf8_general_ci');
            $table->text('terms_n_cond')->nullable()->collation('utf8_general_ci');
            $table->float('net_total',10,2)->nullable();
            $table->float('discount',10,2)->nullable();
            $table->enum('discount_type',['fixed','percentage'])->default('percentage');
            $table->float('grand_tot',10,2)->nullable();
            $table->text('adjustment')->nullable()->collation('utf8_general_ci');
            $table->string('billing_street',200)->nullable()->collation('utf8_general_ci');
            $table->string('billing_city',100)->nullable()->collation('utf8_general_ci');
            $table->string('billing_state',100)->nullable()->collation('utf8_general_ci');
            $table->string('billing_zip',100)->nullable()->collation('utf8_general_ci');
            $table->string('billing_country',100)->nullable()->collation('utf8_general_ci');
            $table->enum('include_shipping',['0','1'])->default('0');
            $table->string('shipping_street',200)->nullable()->collation('utf8_general_ci');
            $table->string('shipping_city',100)->nullable()->collation('utf8_general_ci');
            $table->string('shipping_state',100)->nullable()->collation('utf8_general_ci');
            $table->string('shipping_zip',100)->nullable()->collation('utf8_general_ci');
            $table->string('shipping_country',100)->nullable()->collation('utf8_general_ci');
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
        Schema::dropIfExists('sales_proposal');
    }
}
