<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChangeRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('change_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subscriber_id')->index();
            $table->unsignedBigInteger('billpay_id')->index()->nullable();
            $table->tinyInteger('area_id')->nullable();
            $table->tinyInteger('connection_id')->nullable();
            $table->tinyInteger('package_id')->nullable();
            $table->boolean('status')->default(0);
            $table->tinyInteger('type')->nullable();
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
        Schema::dropIfExists('change_requests');
    }
}
