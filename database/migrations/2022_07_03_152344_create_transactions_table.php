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
            $table->unsignedBigInteger('account_id')->index();
            $table->unsignedBigInteger('expense_id')->index()->nullable();
            $table->unsignedBigInteger('billing_id')->index()->nullable();
            $table->unsignedBigInteger('fund_transfer_id')->index()->nullable();
            $table->double('transaction_amount');
            $table->string('transaction_date');
            $table->tinyInteger('purpose');
            $table->string('transaction_reason')->nullable();
            $table->tinyInteger('transaction_type')->index()->comment('1=Debit/2=Credit');
            $table->text('transaction_info')->nullable();
            $table->integer('payment_type')->index()->comment('1=Cash, 2=Cheque');
            $table->string('cheque_number')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('created_by')->nullable();
            $table->tinyInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
