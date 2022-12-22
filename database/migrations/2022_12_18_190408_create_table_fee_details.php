<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableFeeDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fee_details', function (Blueprint $table) {
            $table->id();
            $table->string('admission_number')->unique();
            $table->string('payment_mode')->nullable();
			$table->tinyInteger('payment_status')->unsigned()->default(0);
            $table->double('fee_amount')->unsigned()->default(0);
            $table->double('due_amount')->unsigned()->default(0);
            $table->double('paid_amount')->unsigned()->default(0);
            $table->timestamp('amount_paid_date');
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
        Schema::dropIfExists('table_fee_details');
    }
}
