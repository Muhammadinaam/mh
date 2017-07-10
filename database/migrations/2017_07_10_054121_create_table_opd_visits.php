<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableOpdVisits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opd_visits', function (Blueprint $table) {
            
            $table->engine = 'InnoDB';
            
            $table->bigIncrements('id');

            $table->integer('doctor_id')->nullable();
            
            $table->datetime('visit_date')->nullable();

            $table->integer('token_number')->nullable();

            $table->string('patient_name')->nullable();
            $table->decimal('patient_age')->nullable();

            $table->string('patient_blood_pressure')->nullable();
            $table->decimal('patient_temperature')->nullable();


            $table->decimal('doctor_fee')->nullable();
            $table->decimal('total_fee')->nullable();

            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('opd_visits');
    }
}
