<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle', function (Blueprint $table) {
            $table->id();
            $table->integer('maker')->nullable();
            $table->string('name')->nullable()->collation('utf8_general_ci');
            $table->integer('driver_id')->nullable();
            $table->string('plate_no')->nullable()->collation('utf8_general_ci');
            $table->string('plate_letter')->nullable()->collation('utf8_general_ci');
            $table->string('vehicle_reg',255)->nullable()->collation('utf8_general_ci');
            $table->string('engine_type')->nullable()->collation('utf8_general_ci');
            $table->integer('model')->nullable();
            $table->string('horse_power')->nullable()->collation('utf8_general_ci');
            $table->integer('type')->nullable();
            $table->string('color')->nullable()->collation('utf8_general_ci');
            $table->integer('year')->nullable();
            $table->string('vin_no')->nullable()->collation('utf8_general_ci');
            $table->string('regs_no')->nullable()->collation('utf8_general_ci');
            $table->string('chasis_no')->nullable()->collation('utf8_general_ci');
            $table->string('avg')->nullable()->collation('utf8_general_ci');
            $table->string('license_plate')->nullable()->collation('utf8_general_ci');
            $table->string('initial_mileage')->nullable()->collation('utf8_general_ci');
            $table->date('license_expiry_date')->nullable();
            $table->date('registration_expiry_date')->nullable();
            $table->enum('is_active',['1','0'])->default('1');
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
        Schema::dropIfExists('vehicle');
    }
}
