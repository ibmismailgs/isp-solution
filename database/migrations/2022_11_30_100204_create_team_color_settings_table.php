<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamColorSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_color_settings', function (Blueprint $table) {
            $table->id();
            $table->string('heading_color')->nullable();
            $table->string('name_color')->nullable();
            $table->string('designation_color')->nullable();
            $table->string('email_color')->nullable();
            $table->string('text_color')->nullable();
            $table->string('underline_color')->nullable();
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
        Schema::dropIfExists('team_color_settings');
    }
}
