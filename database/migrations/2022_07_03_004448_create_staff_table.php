<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedInteger('role');
            $table->string('birth_date');
            $table->string('join_date');
            $table->string('password');
            $table->string('gender');
            $table->text('image');
            $table->string('contact_no');
            $table->string('designation');
            $table->string('salary');
            $table->string('email');
            $table->boolean('status')->default(1);
            $table->text('address')->nullable();
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
        Schema::dropIfExists('staff');
    }
}
