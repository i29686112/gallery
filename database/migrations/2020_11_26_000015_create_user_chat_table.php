<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserChatTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'TG_user_chat';

    /**
     * Run the migrations.
     * @table user_chat
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {

            $table->bigIncrements('user_id')->comment('Unique user identifier');
            $table->bigInteger('chat_id')->nullable()->default(null)->comment('Unique user or chat identifier');

            $table->index(["chat_id"], '');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->tableName);
    }
}
