<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableStudent extends Migration
{
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('admission_number')->unique();
            $table->string('class');
            $table->string('section');
            $table->string('roll_number');
            $table->string('date_of_birth');
            $table->string('gender');
            $table->string('blood_group');
            $table->string('admission_details')->nullable();
            $table->string('transport_details')->nullable();
            $table->string('nationality');
            $table->string('religion');
            $table->string('mother_tongue');
            $table->string('aadhar_number');
            $table->string('address');
            $table->string('emergency_contact_number');
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
        Schema::dropIfExists('students');
    }
}
