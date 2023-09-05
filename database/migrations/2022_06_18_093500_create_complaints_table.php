<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplaintsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('ticket_id')->index();
            $table->unsignedInteger('classification_id')->index();
            $table->unsignedInteger('subscriber_id')->index();
            $table->string('name');
            $table->string('email');
            $table->string('contact_no');
            $table->string('address');
            $table->string('complain_date');
            $table->string('complain_time');
            $table->tinyInteger('piority')->default(1);
            $table->boolean('ticket_option')->default(1);
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
        Schema::dropIfExists('complaints');
    }
}
