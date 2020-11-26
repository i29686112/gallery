<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTelegramUpdateTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'TG_telegram_update';

    /**
     * Run the migrations.
     * @table telegram_update
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {

            $table->bigIncrements('id')->comment('Update\'\'s unique identifier');
            $table->bigInteger('chat_id')->nullable()->default(null)->comment('Unique chat identifier');
            $table->unsignedBigInteger('message_id')->nullable()->default(null)->comment('New incoming message of any kind - text, photo, sticker, etc.');
            $table->unsignedBigInteger('edited_message_id')->nullable()->default(null)->comment('New version of a message that is known to the bot and was edited');
            $table->unsignedBigInteger('channel_post_id')->nullable()->default(null)->comment('New incoming channel post of any kind - text, photo, sticker, etc.');
            $table->unsignedBigInteger('edited_channel_post_id')->nullable()->default(null)->comment('New version of a channel post that is known to the bot and was edited');
            $table->unsignedBigInteger('inline_query_id')->nullable()->default(null)->comment('New incoming inline query');
            $table->unsignedBigInteger('chosen_inline_result_id')->nullable()->default(null)->comment('The result of an inline query that was chosen by a user and sent to their chat partner');
            $table->unsignedBigInteger('callback_query_id')->nullable()->default(null)->comment('New incoming callback query');
            $table->unsignedBigInteger('shipping_query_id')->nullable()->default(null)->comment('New incoming shipping query. Only for invoices with flexible price');
            $table->unsignedBigInteger('pre_checkout_query_id')->nullable()->default(null)->comment('New incoming pre-checkout query. Contains full information about checkout');
            $table->unsignedBigInteger('poll_id')->nullable()->default(null)->comment('New poll state. Bots receive only updates about polls, which are sent or stopped by the bot');
            $table->unsignedBigInteger('poll_answer_poll_id')->nullable()->default(null)->comment('A user changed their answer in a non-anonymous poll. Bots receive new votes only in polls that were sent by the bot itself.');

            $table->index(["chat_id", "channel_post_id"], '');

            $table->index(["chat_id", "message_id"], 'chat_message_id');

            $table->index(["shipping_query_id"], 'shipping_query_id');

            $table->index(["edited_channel_post_id"], 'edited_channel_post_id');

            $table->index(["poll_answer_poll_id"], 'poll_answer_poll_id');

            $table->index(["channel_post_id"], 'channel_post_id');

            $table->index(["poll_id"], 'poll_id');

            $table->index(["pre_checkout_query_id"], 'pre_checkout_query_id');

            $table->index(["callback_query_id"], 'callback_query_id');

            $table->index(["chosen_inline_result_id"], 'chosen_inline_result_id');

            $table->index(["edited_message_id"], 'edited_message_id');

            $table->index(["inline_query_id"], 'inline_query_id');

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
