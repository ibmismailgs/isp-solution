<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('expense_id')->index();
            $table->unsignedInteger('account_id')->index();
            $table->string('expense_number');
            $table->string('name');
            $table->string('date');
            $table->json('category_id');
            $table->json('image')->nullable();
            $table->string('contact_no');
            $table->string('adjust_bill')->nullable();
            $table->string('adjust_amount')->nullable();
            $table->string('total_amount');
            $table->string('amount');
            $table->string('all_amount');
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
        Schema::dropIfExists('expenses');
    }
}
