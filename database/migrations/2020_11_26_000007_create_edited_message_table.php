<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEditedMessageTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'TG_edited_message';

    /**
     * Run the migrations.
     * @table edited_message
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {

            $table->bigIncrements('id')->comment('Unique identifier for this entry');
            $table->bigInteger('chat_id')->nullable()->default(null)->comment('Unique chat identifier');
            $table->unsignedBigInteger('message_id')->nullable()->default(null)->comment('Unique message identifier');
            $table->bigInteger('user_id')->nullable()->default(null)->comment('Unique user identifier');
            $table->timestamp('edit_date')->nullable()->default(null)->comment('Date the message was edited in timestamp format');
            $table->text('text')->nullable()->default(null)->comment('For text messages, the actual UTF-8 text of the message max message length 4096 char utf8');
            $table->text('entities')->nullable()->default(null)->comment('For text messages, special entities like usernames, URLs, bot commands, etc. that appear in the text');
            $table->text('caption')->nullable()->default(null)->comment('For message with caption, the actual UTF-8 text of the caption');

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
