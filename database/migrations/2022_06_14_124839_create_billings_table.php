<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billings', function (Blueprint $table) {
            $table->id();
            $table->string('subscriber_id');
            $table->unsignedBigInteger('invoice')->index();
            $table->tinyInteger('adjust_bill')->nullable();
            $table->double('add_sub')->nullable();
            $table->string('billing_month');
            $table->text('description')->nullable();
            $table->boolean('status')->default(1);
            $table->date('issue_date');
            $table->string('package_id');
            $table->double('total_amount');
            $table->tinyInteger('used_day');
            $table->double('used_amount');
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
        Schema::dropIfExists('billings');
    }
}
