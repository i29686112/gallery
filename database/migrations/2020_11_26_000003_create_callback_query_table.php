<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCallbackQueryTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'TG_callback_query';

    /**
     * Run the migrations.
     * @table callback_query
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Unique identifier for this query');
            $table->bigInteger('user_id')->nullable()->default(null)->comment('Unique user identifier');
            $table->bigInteger('chat_id')->nullable()->default(null)->comment('Unique chat identifier');
            $table->unsignedBigInteger('message_id')->nullable()->default(null)->comment('Unique message identifier');
            $table->char('inline_message_id',
                255)->nullable()->default(null)->comment('Identifier of the message sent via the bot in inline mode, that originated the query');
            $table->char('chat_instance',
                255)->default('')->comment('Global identifier, uniquely corresponding to the chat to which the message with the callback button was sent');
            $table->char('data', 255)->default('')->comment('Data associated with the callback button');
            $table->char('game_short_name',
                255)->default('')->comment('Short name of a Game to be returned, serves as the unique identifier for the game');
            $table->timestamp('created_at')->nullable()->default(null)->comment('Entry date creation');

            $table->index(["chat_id", "message_id"], '');

            $table->index(["user_id"], 'user_id');

            $table->index(["chat_id"], 'chat_id');

            $table->index(["message_id"], 'message_id');
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
