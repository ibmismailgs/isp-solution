<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageColorSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_color_settings', function (Blueprint $table) {
            $table->id();
            $table->string('heading_color')->nullable();
            $table->string('underline_color')->nullable();
            $table->string('package_color')->nullable();
            $table->string('price_color')->nullable();
            $table->string('month_color')->nullable();
            $table->string('text_color')->nullable();
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
        Schema::dropIfExists('package_color_settings');
    }
}
