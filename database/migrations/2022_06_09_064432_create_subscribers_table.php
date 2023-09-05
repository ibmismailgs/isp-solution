<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscribersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('subscriber_id');
            $table->unsignedInteger('role');
            $table->string('name');
            $table->string('initialize_date');
            $table->string('birth_date');
            $table->json('card_type_id')->nullable();
            $table->json('card_no')->nullable();
            $table->unsignedInteger('area_id')->index();
            $table->text('address');
            $table->string('contact_no');
            $table->unsignedInteger('category_id')->index();
            $table->unsignedInteger('connection_id')->index();
            $table->unsignedInteger('package_id')->index();
            $table->unsignedInteger('device_id')->index();
            $table->string('ip_address');
            $table->string('email');
            $table->string('password');
            $table->text('image')->nullable();
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('subscribers');
    }
}
