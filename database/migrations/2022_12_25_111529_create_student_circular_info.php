<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentCircularInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_circular_info', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('circular_id');
            $table->string('category');
            $table->string('description');
            $table->String('class');
            $table->timestamp('circulardate');
            $table->string('content');
            $table->string('circular_tittle');
            $table->string('circular_type');




            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_circular_info');
    }
}
