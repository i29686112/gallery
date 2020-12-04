<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SavedPhotos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('saved_photos', function (Blueprint $table) {
            $table->id();
            $table->string('file_name', 100)->unique()->comment('檔案路徑');
            $table->integer('upload_telegram_user_id')->comment('上傳者的telegram id');
            $table->integer('film_id')->comment('底片分類id');
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
        //
        Schema::dropIfExists('saved_photos');
    }
}
