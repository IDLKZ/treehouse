<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePolygonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('polygons', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->foreignId("marker_id")->references("id")->on("markers")->cascadeOnUpdate()->cascadeOnDelete();
            $table->string("price");
            $table->string("density");
            $table->geometry("geo");
            $table->geometry("free_geo");
            $table->geometry("selled_geo");
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
        Schema::dropIfExists('polygons');
    }
}
