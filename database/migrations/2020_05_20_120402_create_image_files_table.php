<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImageFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_files', function (Blueprint $table) {
            $table->id();
            $table->integer('image_id');
            $table->string('path');
            $table->string('size_type')->nullable();  //smal, medium, large, full
            $table->integer('size')->nullable();  //size in bytes
            $table->string('file_type')->nullable();  //jpg, png
            $table->string('resolution')->nullable();
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
        Schema::dropIfExists('image_files');
    }
}
