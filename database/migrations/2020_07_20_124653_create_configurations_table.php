<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configurations', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->char("name", 255)->index();
            $table->char("hostname");
            $table->unsignedInteger("port");
            $table->unsignedInteger("rotation_speed")->default(140);
            $table->unsignedInteger("left_engine_speed")->default(90);
            $table->unsignedInteger("right_engine_speed")->default(90);
            $table->boolean("primary")->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('configurations');
    }
}
