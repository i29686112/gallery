<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Films extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('films', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique()->comment('底片名稱');
            $table->string('key_name', 100)->unique()->comment('底片名稱(配對關鍵字用)');
            $table->string('cover_image_name', 100)->comment('底片封面照片路徑');
            $table->string('description', 100)->comment('底片描述');
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
        Schema::dropIfExists('films');
    }
}

