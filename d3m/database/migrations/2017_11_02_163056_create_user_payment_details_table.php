<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPaymentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_payment_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('payment_id')->unsigned()->nullable();
            $table->date('payment_date')->nullable();
            $table->string('plan_name')->nullable();
            $table->string('invoice_no')->nullable();
            $table->string('no_of_properties')->nullable();
            $table->string('payment_method')->nullable();
            $table->float('transaction_amount');
            $table->date('payment_due_date')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('branch')->nullable();
            $table->date('cheque_date')->nullable();
            $table->string('status')->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->integer('approved_by')->unsigned()->nullable();
            $table->timestamps();
            $table->timestamp('approved_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_payment_details');
    }
}
