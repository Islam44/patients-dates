<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->foreign('patient_id')->references('user_id')->on('patients')
                ->onUpdate('cascade')->onDelete('set null');
            $table->unsignedBigInteger('pain_id')->nullable();
            $table->foreign('pain_id')->references('id')->on('pains')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->foreign('doctor_id')->references('user_id')->on('doctors')
                ->onUpdate('cascade')->onDelete('set null');
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->foreign('admin_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('set null');
            $table->time('time')->nullable();
            $table->date('date')->nullable();
            $table->enum('accept_by_doctor',['non_ready','waiting','accept','reject'])->default('non_ready');
            $table->enum('accept_by_user',['non_ready','waiting','accept','reject'])->default('non_ready');
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
        Schema::dropIfExists('appointments');
    }
}
